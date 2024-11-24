<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PatientController extends Controller
{
    public function index() {
        $patients = Patient::all();

        // Return all patients with 200 OK status
        return response()->json([
            'data' => $patients
        ], Response::HTTP_OK);
    }

    public function show($id) {
        $patient = Patient::find($id);

        // If the patient is not found, return a 404 response
        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found.'
            ], Response::HTTP_NOT_FOUND);
        }

        // Return the patient data with a 200 OK status
        return response()->json([
            'data' => $patient
        ], Response::HTTP_OK);
    }
}
