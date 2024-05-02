<?php

namespace App\Http\Controllers;

use App\Models\AssistanceRequest;
use App\Models\Patient;
use App\Models\PatientCase;
use Illuminate\Http\Request;

class RequestAssistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all assistance request
        $assistance_requests = AssistanceRequest::query()->select('assistance_requests.id', 'patients.case_no', 'patients.first_name', 'patients.mid_name', 'patients.last_name', 'assistance_requests.status', 'assistance_requests.request_type')->join('patients', 'assistance_requests.case_no', '=', 'patients.case_no')->latest('assistance_requests.created_at')->paginate(16);

        // dd($assistance_requests);

        return view('assistanceRequest.index', compact('assistance_requests'));
    }

    public function search_assitance_request(Request $request)
    {
        // get the data
        $key = $request->key;

        if ($request->ajax()) {
            $assistance_requests = AssistanceRequest::query()->select('assistance_requests.id', 'patients.case_no', 'patients.first_name', 'patients.mid_name', 'patients.last_name', 'assistance_requests.status', 'assistance_requests.request_type')->join('patients', 'assistance_requests.case_no', '=', 'patients.case_no')->orWhere('patients.case_no', 'like', $key . '%')->latest('assistance_requests.created_at')->limit(16)->get();
            return view('components.assistanceRequestList', compact('assistance_requests'));
        } else {
            $assistance_requests = AssistanceRequest::query()->select('assistance_requests.id', 'patients.case_no', 'patients.first_name', 'patients.mid_name', 'patients.last_name', 'assistance_requests.status', 'assistance_requests.request_type')->join('patients', 'assistance_requests.case_no', '=', 'patients.case_no')->orWhere('assistance_requests.status', '=', $key)->latest('assistance_requests.created_at')->paginate(16);
        }

        return view('assistanceRequest.index', compact('assistance_requests'));
        // return view('components.copyright');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        // get patient data
        if (!empty($id) || $id != 0) {
            $patient = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->where('patients.id', $id)->first();
        } else {
            $patient = [
                'case_no' => '',
                'first_name' => '',
                'mid_name' => '',
                'last_name' => '',

                'birth_date' => '',
                'birth_place' => '',
                'blood_type' => '',

                'gender' => '',
                'religion' => '',
                'citizenship' => '',

                'contact_no' => '',
                'address' => '',

                'diagnosis' => '',
                'treatment' => '',
                'admit_date' => '',

                'arrive_time' => '',
                'brought_by' => '',
                'remarks' => '',
            ];
        }

        // dd($patient);

        return view('assistanceRequest.create', compact('patient'));
    }

    // ajax get patient information
    public function get_patient_information(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $patient = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->where('patients.case_no', $request->case_no)->first();
            // dd($patient);
            // if no patient find then fill blanks
            if (empty($patient)) {
                $patient = [
                    'case_no' => '',
                    'first_name' => '',
                    'mid_name' => '',
                    'last_name' => '',

                    'birth_date' => '',
                    'birth_place' => '',
                    'blood_type' => '',

                    'gender' => '',
                    'religion' => '',
                    'citizenship' => '',

                    'contact_no' => '',
                    'address' => '',

                    'diagnosis' => '',
                    'treatment' => '',
                    'admit_date' => '',

                    'arrive_time' => '',
                    'brought_by' => '',
                    'remarks' => '',
                ];
            }
        }

        return view('components.patientInformation', compact('patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get the input data required
        $request->validate([
            'case_number' => 'required|exists:patients,case_no',
            'assistance_type' => 'required',

            'date_applyied' => 'required',
        ]);

        // check if there is a case_applied with that assistance
        $assistance = AssistanceRequest::query()->where('case_no', '=', $request->case_number)->where('request_type', '=', $request->assistance_type)->first();
        if (!empty($assistance)) {
            return redirect()->back()->with('warning', 'Patient Assistance Request Exist.');
        }

        $data = $request->all();

        // register the request for approval
        AssistanceRequest::query()->create([
            'case_no' => $data['case_number'],

            'request_type' => $data['assistance_type'],
            'status' => 'PENDING',
            'request_date' => $data['date_applyied'],
        ]);

        // redirect back
        return redirect()->route('assistanceRequest.index')->with('success', 'New Request Added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('assistanceRequest.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get patient data
        if (!empty($id) || $id != 0) {
            $patient = AssistanceRequest::query()->select(
                'assistance_requests.id',
                'patients.case_no',
                'patients.first_name',
                'patients.mid_name',
                'patients.last_name',

                'patients.birth_date',
                'patients.birth_place',
                'patients.blood_type',

                'patients.gender',
                'patients.religion',
                'patients.citizenship',

                'patients.contact_no',
                'patients.address',

                'patient_cases.diagnosis',
                'patient_cases.treatment',
                'patient_cases.admit_date',

                'patient_cases.arrive_time',
                'patient_cases.brought_by',
                'patient_cases.remarks',

                'assistance_requests.request_type',
                'assistance_requests.request_date',
            )->join('patient_cases', 'assistance_requests.case_no', '=', 'patient_cases.case_no')->join('patients', 'assistance_requests.case_no', '=', 'patients.case_no')->where('assistance_requests.id', $id)->first();
            // dd($patient);
        } else {
            $patient = [
                'id' => '',
                'case_no' => '',
                'first_name' => '',
                'mid_name' => '',
                'last_name' => '',

                'birth_date' => '',
                'birth_place' => '',
                'blood_type' => '',

                'gender' => '',
                'religion' => '',
                'citizenship' => '',

                'contact_no' => '',
                'address' => '',

                'diagnosis' => '',
                'treatment' => '',
                'admit_date' => '',

                'arrive_time' => '',
                'brought_by' => '',
                'remarks' => '',

                'request_type' => '',
                'request_date' => '',
            ];
        }


        return view('assistanceRequest.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get the input data required
        $request->validate([
            // 'id' => 'required',
            'status' => 'required',
        ]);

        // get assistant request data
        $data = $request->all();

        // update the status of the request accordingly
        $request_assistance = AssistanceRequest::query()->where('id', '=', $id)->update([
            'status' => $data['status'],
        ]);

        // dd($request->status);

        // redirect back
        return redirect()->route('assistanceRequest.index')->with('info', 'Request ' . $request->status . '.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
