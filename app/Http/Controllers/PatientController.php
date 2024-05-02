<?php

namespace App\Http\Controllers;

use App\Models\AssistanceRequest;
use App\Models\DespenseMedicine;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\ReportsController;
use App\Models\User;
use App\Notifications\NewPatient;

class PatientController extends Controller
{
    public function index()
    {
        // get the data of patientss
        $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.created_at')->paginate(16);
        $patients_by_bloodTypes = Patient::query()->groupBy('blood_type')->get('blood_type');
        $patients_by_citizenship = Patient::query()->groupBy('citizenship')->get('citizenship');

        $barangays = Patient::query()->selectRaw('count(id) as total, barangay')->groupBy('barangay')->get();
        // dd($patients_by_bloodTypes);

        // give that data to the view
        return view('patient.index', compact('patients', 'patients_by_bloodTypes', 'patients_by_citizenship', 'barangays'));
    }

    public function by_barangay()
    {
        // get the data of patients
        $barangays = Patient::query()->selectRaw('count(id) as total, barangay')->groupBy('barangay')->paginate(12);
        // dd($patients_by_bloodTypes);

        // give that data to the view
        return view('patient.by-barangay', compact('barangays'));
    }

    public function sort_patient(Request $request)
    {
        $key = $request->key;
        $value = $request->value;

        if ($key == "brgy") {
            $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->where('barangay', '=', $value)->latest('patients.created_at')->paginate(16);
        } else {
            $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.created_at')->paginate(16);
        }


        $patients_by_bloodTypes = Patient::query()->groupBy('blood_type')->get('blood_type');
        $patients_by_citizenship = Patient::query()->groupBy('citizenship')->get('citizenship');
        $barangays = Patient::query()->selectRaw('count(id) as total, barangay')->groupBy('barangay')->get();

        $patients->appends(['key' => $key]);
        $patients->appends(['value' => $value]);

        // give that data to the view
        return view('patient.index', compact('patients', 'patients_by_bloodTypes', 'patients_by_citizenship', 'barangays'));
    }

    public function search_patient_details(Request $request)
    {
        // get the data
        $key = $request->key;

        if ($request->ajax()) {
            $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->where('patients.first_name', 'like', '%' . $key . '%')->orWhere('patients.last_name', 'like', '%' . $key . '%')->orWhere('patients.mid_name', 'like', '%' . $key . '%')->latest('patients.created_at')->limit(16)->get();
            return view('components.patientCardList', compact('patients'));
            // dd($patient);
        } else {
            $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->orWhere('patients.gender', '=', $key)->orWhere('patients.blood_type', 'like', $key . "%")->orWhere('patients.citizenship', '=', $key)->latest('patients.created_at')->paginate(16);
            $patients_by_bloodTypes = Patient::query()->groupBy('blood_type')->get('blood_type');
            $patients_by_citizenship = Patient::query()->groupBy('citizenship')->get('citizenship');

            $patients->appends(['key' => $key]);
        }

        return view('patient.index', compact('patients', 'patients_by_bloodTypes', 'patients_by_citizenship'));
        // return view('components.copyright');
    }

    public function show_patient_partial_details(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $patient = Patient::query()->where('id', $request->id)->first();

            // dd($patient);
        }

        return view('components.patientDetailsModal', compact('patient'));
    }

    public function show_patient_diagnosis_details(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $diagnosis = PatientCase::query()->where('diagnosis_no', $request->no)->where('case_no', $request->pid)->first();
            $despensed_medicines = DespenseMedicine::query()->selectRaw('despense_medicines.medicine, sum(despense_medicines.quantity) as total, despense_medicines.created_at, medicines.name')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.medicine_id')->where('despensed', '=', $request->pid)->where('diagnosis', $diagnosis->diagnosis_no)->groupBy(['despense_medicines.medicine', 'despense_medicines.created_at', 'medicines.name'])->get();
            // dd($diagnosis);
        }

        return view('components.patientDiagnosisDetailsModal', compact('diagnosis', 'despensed_medicines'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // generate case number for the new patient
        $generated_case_no = fake()->numerify('0######');

        date_default_timezone_set("Asia/Taipei");
        $timezome = date_default_timezone_get();
        $arrival_time = date('H:i');

        $date_today = date('Y-m-d');
        $diagnosis_no = fake()->numerify('D######');

        // dd($date_today);

        return view('patient.create', compact(
            'generated_case_no',
            'arrival_time',
            'date_today',
            'diagnosis_no',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input());
        // get the input data required
        $request->validate([
            'case_number' => 'required|unique:patients,case_no',
            'first_name' => 'required',
            'last_name' => 'required',

            'birthDate' => 'required',
            'age' => 'required',
            'birth_place' => 'required',
            'blood_type' => 'required',

            'gender' => 'required',
            'citizenship' => 'required',

            'contact_number' => 'required',
            'address' => 'required',
            'barangay' => 'required',
        ]);


        // check if the name of the patient exist already
        if (!empty(Patient::query()->where('first_name', $request->first_name)->where('last_name', $request->last_name)->orWhere('case_no', $request->case_number)->first())) {
            return redirect()->back()->with('warning', 'Patient Record Already Exist.');
        }

        $data = $request->all();
        // dd($data);

        // store the data in the database patient table
        $patient = Patient::query()->create([
            'case_no' => $data['case_number'],
            'first_name' => $data['first_name'],
            'mid_name' => empty($data['mid_name']) ? ' ' : $data['mid_name'],
            'last_name' => $data['last_name'],

            'birth_date' => $data['birthDate'],
            'age' => $data['age'],
            'birth_place' => $data['birth_place'],
            'blood_type' => $data['blood_type'],

            'gender' => $data['gender'],
            'religion' => $data['religion'],
            'citizenship' => $data['citizenship'],

            'contact_no' => $data['contact_number'],
            'address' => $data['address'],
            'barangay' => $data['barangay'],
        ]);

        // check if the patient case has an input to input in the database
        if (!empty($data['diagnosis'])) {
            // add the patient case in the database
            PatientCase::query()->create([
                'case_no' => $data['case_number'],
                'diagnosis_no' => $data['diagnosis_number'],
                'diagnosis' => $data['diagnosis'],
                'treatment' => $data['treatment'],
                'admit_date' => $data['admit_date'],

                'arrive_time' => $data['time_arrival'],
                'brought_by' => $data['brought_by'],
                'remarks' => $data['remarks'],
            ]);
        }

        // send notification
        $patient_fullname =$data['first_name'] . ' ' . $data['mid_name'] . ' ' . $data['last_name'];
        $users = User::all();
        Notification::send($users, new NewPatient($patient->id, $patient_fullname));


        // redirect back
        return redirect()->route('patient.create')->with('success', 'New Patient Added.')->with('patient_id', $patient->id);
    }

    public function add_new_diagnosis(Request $request)
    {
        // get the input data required
        $request->validate([
            'diagnosis_number' => 'required|unique:patient_cases,diagnosis_no',
            'diagnosis' => 'required',
            'treatment' => 'required',
            // 'birthDate' => 'required',
            'admit_date' => 'required',
        ]);

        $data = $request->all();

        $patient = Patient::query()->where('case_no', $data['case_number'])->first();

        // add the patient case in the database
        PatientCase::query()->create([
            'case_no' => $data['case_number'],
            'diagnosis_no' => $data['diagnosis_number'],
            'diagnosis' => $data['diagnosis'],
            'treatment' => $data['treatment'],
            'admit_date' => $data['admit_date'],

            'arrive_time' => $data['time_arrival'],
            'brought_by' => $data['brought_by'],
            'remarks' => $data['remarks'],
        ]);

        // redirect back
        return redirect()->route('patient.show', $patient->id)->with('success', ' Patient Diagnosis Updated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!empty($id) || $id != 0) {
            $patient = Patient::query()->where('id', $id)->first();
            $diagnosis_no = fake()->numerify('D######');
            // get the patient cases
            $patient_case = PatientCase::query()->where('case_no', '=', $patient->case_no)->latest()->first();
            $diagnosis_list = PatientCase::query()->where('case_no', '=', $patient->case_no)->latest()->get();
            // get patitent request assistance
            $patient_assistances = AssistanceRequest::query()->where('case_no', '=', $patient->case_no)->get();
            // get patitent despensed medicines
            $despensed_medicines = DespenseMedicine::query()->selectRaw('despense_medicines.medicine, sum(despense_medicines.quantity) as total, despense_medicines.created_at, medicines.name')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.medicine_id')->where('despensed', '=', $patient->case_no)->groupBy(['despense_medicines.medicine', 'despense_medicines.created_at', 'medicines.name'])->get();
            // $despensed_medicines = DespenseMedicine::query()->selectRaw('medicine, sum(quantity) as total, created_at')->where('despensed', '=', $patient->case_no)->groupBy(['medicine', 'created_at'])->get();
        } else {
            return view('patient.index')->with('error', 'No patient with that exist.');
        }

        return view('patient.show', compact('patient', 'patient_case', 'patient_assistances', 'despensed_medicines', 'diagnosis_list', 'diagnosis_no'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!empty($id) || $id != 0) {
            $patient = Patient::query()->where('id', $id)->first();

            // get the patient cases
            $patient_case = PatientCase::query()->where('case_no', '=', $patient->case_no)->first();
        } else {
            return view('patinet.index')->with('error', 'No patient with that exist.');
        }

        return view('patient.edit', compact('patient', 'patient_case'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get the input data
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',

            'birthDate' => 'required',
            'age' => 'required',
            'birth_place' => 'required',
            'blood_type' => 'required',

            'gender' => 'required',
            'citizenship' => 'required',

            'contact_number' => 'required',
            'address' => 'required',
        ]);

        $data = $request->all();
        // dd($data);

        // store the data in the database patient table
        $patient = Patient::query()->where('id', '=', $id)->update([
            'case_no' => $data['case_number'],
            'first_name' => $data['first_name'],
            'mid_name' => empty($data['mid_name']) ? ' ' : $data['mid_name'],
            'last_name' => $data['last_name'],

            'birth_date' => $data['birthDate'],
            'age' => $data['age'],
            'birth_place' => $data['birth_place'],
            'blood_type' => $data['blood_type'],

            'gender' => $data['gender'],
            'religion' => $data['religion'],
            'citizenship' => $data['citizenship'],

            'contact_no' => $data['contact_number'],
            'address' => $data['address'],
        ]);

        // check if the patient case has an input and input it in the database
        // if (!empty($data['diagnosis'])) {
        //     // add the patient case in the database
        //     $patient_case = PatientCase::query()->where('case_no', '=', $data['case_number'])->update([
        //         'case_no' => $data['case_number'],
        //         'diagnosis' => $data['diagnosis'],
        //         'treatment' => $data['treatment'],
        //         'admit_date' => $data['admit_date'],

        //         'arrive_time' => $data['time_arrival'],
        //         'brought_by' => $data['brought_by'],
        //         'remarks' => $data['remarks'],
        //     ]);
        // }

        // redirect back
        return redirect()->route('patient.edit', $id)->with('success', 'Patient Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
