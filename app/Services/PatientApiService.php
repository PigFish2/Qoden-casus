<?php
namespace App\Services;

use App\Models\Patient;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PatientApiService
{
    protected $baseUrl;
    protected $bearerToken;

    public function __construct()
    {
        $this->baseUrl = env('PATIENTS_API_URL');
        $this->bearerToken = env('PATIENTS_API_BEARER');
    }

    /**
     * Call the external API to get patients or specific patient by id.
     * 
     * Since the API doesn't exist, it either generates random data or returns existing one in this database.
     * @param int $id (optional) The ID of specific patient to get
     * @return array $patients Array of 1 or more patients.
     */
    public function fetchPatients($id = null) {
        $url = $this->baseUrl . '/patients'; // Endpoint to get patients.

        if ($id) {
            $url .= '/' . $id;
            
            // Because theres no actual api, this simulates returning a Patient by ID.
            return $this->returnPatientById($id);
        }

        try {
            $patients = [];
            for ($i=0; $i < 3; $i++) { 
                $patients[] = $this->returnNewOrExisting();
            }
            return $patients;

            // Since there is no actual API, this does not work properly so its more just to show how it might look after this line. I usually shape it after debugging but thats tough with no data.
            $response = Http::withToken($this->bearerToken)->get($url);

            if ($response->successful()) {
                return $response->json(); // Return the JSON response as an array
            }

            // Handle non-2xx responses
            $response->throw();
        } catch (\Exception $e) {
            Log::error('Failed to fetch patients: ' . $e->getMessage());
            throw new \Exception('Failed to fetch patients: ' . $e->getMessage());
        }
    }

    /**
     * This function either generates a new Patient or gets a existing randomly from database.
     * This simulates the API returning either a new patient or a already existing one.
     */
    private function returnNewOrExisting() {
        if (rand(0,1)) {
            $randomPatient = Patient::inRandomOrder()->first();

            // When database is empty, $randomPatient can be null.
            $patient = $randomPatient ? $randomPatient->convertToArray() : Patient::factory()->make()->convertToArray();
        } else {
            $patient = Patient::factory()->make()->convertToArray();
        }

        return $patient;
    }

    /**
     * Return a Patient already in the database or create a new Patient with the ID given.
     */
    private function returnPatientById($id) {
        if (Patient::where('id', $id)->exists()) {
            $patient = Patient::where('id', $id)->first()->convertToArray();
            // $patient['name'] = 'Something changed'; // You can put this out of commentary to test out when a patient data changes.
        } else {
            $patient = Patient::factory()->make()->convertToArray();
            $patient['id'] = $id;
        }

        return [$patient];
    }
}

?>