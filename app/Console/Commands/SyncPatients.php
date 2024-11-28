<?php

namespace App\Console\Commands;

use App\Models\Patient;
use App\Services\PatientApiService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SyncPatients extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-patients {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get patients from external api, optionally, get a speficic one by ID. And update existing or create new.';

    protected $apiService;

    public function __construct(PatientApiService $apiService)
    {
        parent::__construct();
        $this->apiService = $apiService;
    }
    
    public function handle()
    {
        $id = $this->argument('id'); // Get the optional 'id' argument

        if ($id) {
            $this->info("Fetching data for patient ID: {$id}...");
        } else {
            $this->info('Fetching all patients...');
        }

        try {
            // Call the service to get the Patients or specific one by ID.
            $patients = $this->apiService->fetchPatients($id);
            
            $this->info('Data fetched successfully:');
        } catch (\Exception $e) {
            $this->error('Error fetching data: ' . $e->getMessage());
            Log::error('Error fetching data: ' . $e->getMessage());
            return;
        }
        
        foreach ($patients as $patient) {
            $existingPatient = Patient::where('id', $patient['id'])->first();
            
            if ($existingPatient) {
                // Turn the Patient existing in database and the Patient obtained from the API into a hash to check if any value has changed.
                $hashApiPatient = hash('sha256', serialize($patient));
                $hashExistingPatient = hash('sha256', serialize($existingPatient->convertToArray()));

                // Check if any data has changed, if so, update. This prevents running an update without changing any data.
                if ($hashApiPatient != $hashExistingPatient) {
                    $this->info('Patient with id '. $patient['id'] . ' has their changes updated!');
                    $existingPatient->update($patient);
                    continue;
                }
                $this->info('Patient with id '. $patient['id'] . ' has no changes.');
            } else {
                $newPatient = Patient::create($patient);
                $this->info('Created a new Patient with ID: '. $newPatient['id']);
            }
        }
    }
}
