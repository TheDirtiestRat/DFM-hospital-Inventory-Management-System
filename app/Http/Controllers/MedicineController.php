<?php

namespace App\Http\Controllers;

use App\Events\RecordDespenseMedicine;
use App\Models\BatchMedicine;
use App\Models\DespenseMedicine;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get the medicine records
        $medicines = Medicine::query()->latest()->paginate(16);

        // list of all the batches
        $batches = Medicine::query()->selectRaw('count(id) as total, batch_no')->groupBy('batch_no')->get('batch_no');

        // dd($batches);

        return view('medicine.index', compact(
            'medicines',
            'batches',
        ));
    }

    public function get_meds_list(Request $request)
    {
        // $data_key = $request->all();
        if ($request->key == "get_expired") {
            $expired_meds = Medicine::query()->selectRaw('medicine_id, datediff(`expired_date`, date(`created_at`))')->whereRaw('datediff(`expired_date`, date(`created_at`)) <= 0')->get();
            $exp_meds = array();
            foreach ($expired_meds as $key => $value) {
                array_push($exp_meds, $value->medicine_id);
            }
            // dd($exp_meds);

            $medicines = Medicine::query()->whereIn('medicine_id', $exp_meds)->paginate(16);
        } else if ($request->key == 'to_expire') {
            $not_expired_meds = Medicine::query()->selectRaw('medicine_id, datediff(`expired_date`, date(`created_at`))')->whereRaw('datediff(`expired_date`, date(`created_at`)) < 30')->get();
            $not_exp_meds = array();
            foreach ($not_expired_meds as $key => $value) {
                array_push($not_exp_meds, $value->medicine_id);
            }
            $medicines = Medicine::query()->whereIn('medicine_id', $not_exp_meds)->paginate(16);
        } else if ($request->key == 'get_not_expired') {
            $not_expired_meds = Medicine::query()->selectRaw('medicine_id, datediff(`expired_date`, date(`created_at`))')->whereRaw('datediff(`expired_date`, date(`created_at`)) >= 60')->get();
            $not_exp_meds = array();
            foreach ($not_expired_meds as $key => $value) {
                array_push($not_exp_meds, $value->medicine_id);
            }
            $medicines = Medicine::query()->whereIn('medicine_id', $not_exp_meds)->paginate(16);
        } else if ($request->key == 'get_by_batch' && !empty($request->batch)) {
            $medicines = Medicine::query()->where('batch_no', $request->batch)->paginate(16);
        }

        // dd($medicines);
        $medicines->appends(['key' => $request->key]);
        $medicines->appends(['batch' => $request->batch]);

        // list of all the batches
        $batches = Medicine::query()->selectRaw('count(id) as total, batch_no')->groupBy('batch_no')->get('batch_no');

        return view('medicine.index', compact(
            'medicines',
            'batches',
        ));
    }

    public function despensed_meds_list()
    {
        // get the medicine records
        $medicine = Medicine::query()->get('name');
        $despensed_meds = DespenseMedicine::query()->select([
            'despense_medicines.id',
            'despense_medicines.medicine',
            'despense_medicines.quantity',
            'despense_medicines.despenser',
            'despense_medicines.created_at',

            'patients.case_no',
            'patients.first_name',
            'patients.mid_name',
            'patients.last_name',

            'medicines.medicine_id',
            // 'medicines.photo',

        ])->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.name')->whereIn('despense_medicines.medicine', $medicine)->paginate(16);

        // dd($despensed_meds);

        return view('medicine.list_despense', compact(
            'despensed_meds',
        ));
    }

    public function search_medicine(Request $request)
    {
        // get the data
        $key = $request->key;

        if ($request->ajax()) {
            $medicines = Medicine::query()->where('name', 'like', '%' . $key . '%')->latest('created_at')->limit(16)->get();

            // if is not a despensed list card
            if ($request->despensed_list == false || empty($request->despensed_list)) {
                return view('components.medicineCardList', compact('medicines'));
            } else {
                return view('components.medicineDespenseList', compact('medicines'));
            }

            // dd($patient);
        } else {
            $operator = '';
            if ($key == 100) {
                $operator = '>';
            } else {
                $operator = '<';
            }
            // dd($key);
            $medicines = Medicine::query()->where('quantity', $operator, $key)->paginate(16);
            $medicines->appends(['key' => $key]);
            // dd($medicines);
        }

        return view('medicine.index', compact('medicines'));
        // return view('components.copyright');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $date_today = date('Y-m-d');
        // generate the medicine id
        $med_id = fake()->numerify('M#####');

        // dd($med_id);

        return view('medicine.create', compact(
            'med_id',
            'date_today',
        ));
    }

    public function create_by_batch()
    {
        $date_today = date('Y-m-d');
        // generate the medicine id
        // $med_id = fake()->numerify('M#####');

        return view('medicine.create-batch', compact(
            // 'med_id',
            'date_today',
        ));
    }

    public function despense_medicine()
    {
        // get the medicine records
        $medicines = Medicine::query()->latest()->limit(6)->get();

        return view('medicine.despense', compact('medicines'));
    }

    // store new data through Importing CSV
    public function import_by_batch()
    {
        $date_today = date('Y-m-d');

        return view('medicine.import-batch', compact('date_today'));
    }
    public function import(Request $request)
    {
        // get the input data required
        $request->validate([
            'file' => 'required|file',
        ]);

        // get the file data
        $file = $request->file('file');
        $fileContents = file($file->getPathname());
        $r_data = $request->input();

        $batch_no = $request->batch_no;

        $medicines = array();

        for ($i = 0; $i < count($fileContents); $i++) {
            if ($i != 0) {
                $data = str_getcsv($fileContents[$i]);

                // dd($data);

                if (count($data) <= 7 || $data == null) {
                    return back()->with('error', 'The Imported CSV file does not match with the template.');
                }

                $med_id = fake()->numerify('M#####');

                $element = [
                    'medicine_id' => $med_id,

                    'name' => $data[1],
                    'manufacturer' => $data[2],
                    'type' => $data[3],

                    // 'quantity' => 100,
                    'package_type' => $data[4],
                    // 'mesurement' => $data[5],
                    // 'mesurement_value' => $data[6],

                    'photo' => 'aclc500px.png',
                    'batch_no' => $data[5],
                    'description' => $data[6],

                    'expired_date' => $data[7],
                ];

                array_push($medicines, $element);

                // Medicine::query()->create([
                //     'medicine_id' => $med_id,

                //     'name' => $data[1],
                //     'manufacturer' => $data[2],
                //     'type' => $data[3],

                //     'quantity' => 100,
                //     'package_type' => $data[4],
                //     'mesurement' => $data[5],
                //     'mesurement_value' => $data[6],

                //     'photo' => 'aclc500px.png',
                //     'batch_no' => $data[7],
                //     'description' => $data[8],

                //     'expired_date' => $data[9],
                //     // Add more fields as needed
                // ]);

                // $batch_id = fake()->numerify('B#####');

                // // also insert batch medicine
                // BatchMedicine::query()->create([
                //     'batch_id' => $batch_id,
                //     'batch_title' => $r_data['batch_title'],
                //     'medicine_id' => $med_id,
                //     'stock_date' => date('Y-m-d'),
                //     'expired_date' => $data[9],
                // ]);
            }
        }

        // foreach ($fileContents as $line) {
        //     $data = str_getcsv($line);

        //     // dd($data);

        //     $med_id = fake()->numerify('M#####');

        //     Medicine::query()->updateOrCreate([
        //         'medicine_id' => $med_id,

        //         'name' => $data[1],
        //         'manufacturer' => $data[2],
        //         'type' => $data[3],

        //         'quantity' => 1,
        //         'package_type' => $data[4],
        //         'mesurement' => $data[5],
        //         'mesurement_value' => $data[6],

        //         'photo' => 'aclc500px.png',
        //         'batch_no' => $data[7],
        //         'description' => $data[8],

        //         'expired_date' => $data[9],
        //         // Add more fields as needed
        //     ]);

        //     $batch_id = fake()->numerify('B#####');

        //     // also insert batch medicine
        //     BatchMedicine::query()->create([
        //         'batch_id' => $batch_id,
        //         'batch_title' => $r_data['batch_title'],
        //         'medicine_id' => $med_id,
        //         'stock_date' => date('m-d-Y'),
        //         'expired_date' => $data[9],
        //     ]);
        // }


        // get the medicine records
        // $medicines = Medicine::query()->latest()->paginate(16);

        // redirect back
        $date_today = date('Y-m-d');

        return view('medicine.import-batch', compact('date_today', 'medicines', 'batch_no'));
        // return redirect()->route('medicine.index')->with('success', 'Medicine Data Imported.');
    }

    // export data
    public function export()
    {
        $medicines = Medicine::query()->limit(10)->get();
        $csvFileName = date('Y-m-d') . '-DFMmedicinesTemplate.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];

        $handle = fopen('php://output', 'w');
        fputcsv($handle, [
            'Medicine Id',

            'Name',
            'Manufacturer',
            'Medicine Type',

            // 'Quantity',
            'Package Type',
            // 'Mesure Value',
            // 'Mesurement',

            'Description',
            'Batch No.',

            'Expiration'
        ]); // Add more headers as needed

        foreach ($medicines as $medicine) {
            $description = $medicine->description;
            fputcsv($handle, [
                $medicine->medicine_id,

                $medicine->name,
                $medicine->manufacturer,
                $medicine->type,

                $medicine->package_type,
                // $medicine->mesurement,
                // $medicine->mesurement_value,

                $description,
                $medicine->batch_no,

                $medicine->expired_date
            ]); // Add more fields as needed
        }

        fclose($handle);

        return Response::make('', 200, $headers);
        // return Response::make('', 200, $headers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // get the input data required
        $request->validate([
            'medicine_id' => 'required|unique:medicines,medicine_id',

            'name' => 'required|unique:medicines,name',
            'manufacturer' => 'required',
            'medicine_type' => 'required',

            'quantity' => 'required',
            'pakage_type' => 'required',
            'mesurement' => 'required',
            'mesurement_value' => 'required',

            'batch_no' => 'required',
            // 'batch_title' => 'required',
            'description' => '',

            'stock_date' => 'required',

            'expired_date' => 'required',
        ]);

        $data = $request->all();
        // dd($data);

        // add the profile picture
        $newPhotoName = 'aclc500px.png';
        if ($request->photo != null) {
            $newPhotoName = $request->input('medicine_id') . "-" . $request->name . "." . $request->photo->guessExtension();
            $request->file('photo')->storeAs('medicine img', $newPhotoName, 'public');
        }

        // store the data in the database patient table
        Medicine::query()->create([
            'medicine_id' => $data['medicine_id'],

            'name' => $data['name'],
            'manufacturer' => $data['manufacturer'],
            'type' => $data['medicine_type'],

            'package_type' => $data['pakage_type'],
            'mesurement' => $data['mesurement'],
            'mesurement_value' => $data['mesurement_value'],
            'quantity' => $data['quantity'],

            'photo' => $newPhotoName,
            'batch_no' => $data['batch_no'],
            'description' => $data['description'],

            'expired_date' => $data['expired_date'],
        ]);

        // also insert batch medicine
        BatchMedicine::query()->create([
            'batch_id' => $data['batch_no'],
            'batch_title' => 'ABC',
            'medicine_id' => $data['medicine_id'],
            'stock_date' => $data['stock_date'],
            'expired_date' => $data['expired_date'],
        ]);

        // redirect back
        return redirect()->route('medicine.index')->with('success', 'New Medicine Added.');
    }

    public function store_batch(Request $request)
    {
        // get the input data required
        $request->validate([
            // 'medicine_id' => 'required|unique:medicines,medicine_id',

            'name' => 'required',
            'manufacturer' => 'required',
            'medicine_type' => 'required',

            'quantity' => 'required',
            'pakage_type' => 'required',
            'mesurement' => 'required',
            'mesurement_value' => 'required',

            'batch_no' => 'required',
            // 'batch_title' => 'required',
            // 'description' => '',

            'stock_date' => 'required',

            'expired_date' => 'required',
        ]);

        $data = $request->all();
        // dd($data);

        // add the profile picture
        $newPhotoName = 'aclc500px.png';
        // if ($request->photo != null) {
        //     $newPhotoName = $request->input('medicine_id') . "-" . $request->name . "." . $request->photo->guessExtension();
        //     $request->file('photo')->storeAs('medicine img', $newPhotoName, 'public');
        // }

        for ($i = 0; $i < count($data['name']); $i++) {
            // generate the medicine id
            $med_id = fake()->numerify('M#####');
            // store the data in the database patient table
            Medicine::query()->create([
                'medicine_id' => $med_id,

                'name' => $data['name'][$i],
                'manufacturer' => $data['manufacturer'][$i],
                'type' => $data['medicine_type'][$i],

                'package_type' => $data['pakage_type'][$i],
                'mesurement' => $data['mesurement'][$i],
                'mesurement_value' => $data['mesurement_value'][$i],
                'quantity' => $data['quantity'][$i],

                'photo' => $newPhotoName,
                'batch_no' => $data['batch_no'],
                'description' => '',

                'expired_date' => $data['expired_date'][$i],
            ]);

            // also insert batch medicine
            BatchMedicine::query()->create([
                'batch_id' => $data['batch_no'],
                'batch_title' => 'ABCD',
                // 'batch_title' => $data['batch_title'],
                'medicine_id' => $med_id,
                'stock_date' => $data['stock_date'],
                'expired_date' => $data['expired_date'][$i],
            ]);
        }

        // redirect back
        return redirect()->route('medicine.index')->with('success', 'New Batch of Medicine Added.');
    }

    // prints pdf of the despense medicine
    public function pdf_reciept_despense_medicine(Request $request)
    {
        // dd("test func");

        // $day_today = date('m-d-Y');

        // $patient = Patient::query()->where('id', $id)->first();
        // $patient_case = PatientCase::query()->where('case_no', '=', $patient->case_no)->latest()->first();

        // $despensed_medicines = array();
        // for ($i = 0; $i < count($medicine); $i++) {
        //     $med = Medicine::query()->where('medicine_id', $medicine[$i])->first();
        //     // dd($med->name);
        //     $data = [
        //         'id' => $med->medicine_id,
        //         'medicine' => $med->name,
        //         'quantity' => $quantity[$i]
        //     ];

        //     array_push($despensed_medicines, $data);
        // }
        // // $meds_quantity = array();
        // // dd($despensed_medicines);

        // // image logo
        // $img_logo = public_path('storage/images/ormoc.png');

        // // print by pdd
        // $pdf = Pdf::loadView('pdf.despens_reciept', compact('patient', 'patient_case', 'despensed_medicines', 'img_logo'));
        // download the pdf
        // return $pdf->download($day_today . '_reciept.pdf');
        if ($request->ajax()) {
            dd($request->medicines);
        }

        return Pdf::loadHTML('<h1>Test</h1>')->setPaper('a4', 'landscape')->download('myfile.pdf');
    }

    // despense the medicine and record it in the data base
    public function record_despense_medicine(Request $request)
    {
        // get the input data required
        $request->validate([
            'despenser' => 'required',
            'patient_case_id' => 'required|exists:patients,case_no',
            'diagnosis' => 'required',
            'medicine' => 'required',
            'quantity' => 'required',
        ]);

        // dd($request->input('medicine'));

        // get patient info
        $patient = Patient::query()->where('case_no', $request->input('patient_case_id'))->first();

        // call the event
        // event(new RecordDespenseMedicine($patient->id, $request->input('medicine'), $request->input('quantity')));

        // dd($request->input());
        $data = array();

        // get each medicine
        for ($i = 0; $i < count($request->input('medicine')); $i++) {
            $inputs = [
                'despenser' => $request->input('despenser'),
                'despensed' => $patient->case_no,
                'medicine' => $request->input('medicine')[$i],
                'diagnosis' => $request->input('diagnosis'),
                'quantity' => $request->input('quantity')[$i],
            ];

            // reduce the quantity of the medicine pick base by the quantity given to the patient
            $medicine = Medicine::query()->where('medicine_id', $request->input('medicine')[$i])->get(['medicine_id', 'name', 'quantity'])->first();
            $updated_medicine = Medicine::query()->where('medicine_id', $medicine->medicine_id)->where('quantity', '>=', 0)->update([
                'quantity' => $medicine->quantity - $inputs['quantity'],
            ]);

            // dd($inputs);

            array_push($data, $inputs);
        }

        // dd($data);

        // store the data in the database patient table
        foreach ($data as $key => $value) {
            DespenseMedicine::query()->create($value);
        }

        // redirect back
        return redirect()->route('despenseMedicine')->with('success', 'Medicine Despensed To the Patient.')->with('patient', $patient->id)->with('medicines', $request->input('medicine'))->with('quantities', $request->input('quantity'));
    }

    public function get_patient_info(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $patient = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->where('patients.case_no', $request->case_no)->latest('patient_cases.created_at')->first([
                // 'patients.first_name',
                // 'patients.mid_name',
                // 'patients.last_name',
                'patients.*',
                'patient_cases.*',
                // 'patient_cases.diagnosis',
            ]);
        }

        return view("components.patientInfoDespense", compact('patient'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function show_details(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $medicine = Medicine::query()->where('id', $request->id)->first();
            $despensed_meds = DespenseMedicine::query()->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->where('despense_medicines.medicine', $medicine->name)->get([
                'despense_medicines.quantity',
                'patients.case_no',
                'patients.first_name',
                'patients.mid_name',
                'patients.last_name',
                'despense_medicines.despenser',
                'despense_medicines.created_at'
            ]);
            // dd($medicine);
        }

        return view('components.medicineDetailsModal', compact('medicine', 'despensed_meds'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // get specifig medicine info
        $medicine = Medicine::query()->where('id', $id)->first();
        $batch = BatchMedicine::query()->where('batch_id', $medicine->batch_no)->first();

        return view('medicine.edit', compact('medicine', 'batch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // get the input data required
        $request->validate([
            'medicine_id' => 'required',

            'name' => 'required',
            'manufacturer' => 'required',
            'medicine_type' => 'required',

            'quantity' => 'required',
            'pakage_type' => 'required',
            'mesurement' => 'required',
            'mesurement_value' => 'required',

            'batch_no' => 'required',
            'batch_title' => 'required',
            'description' => '',

            'stock_date' => 'required',

            'expired_date' => 'required',
        ]);

        $data = $request->all();
        // dd($data);

        // update the photo if theres new
        $newPhotoName = '';
        if ($request->photo != null) {
            // find and deletes the image of the employee
            $this->delete_image($id);

            $newPhotoName = $request->input('medicine_id') . "-" . $request->name . "." . $request->photo->guessExtension();
            $request->file('photo')->storeAs('medicine img', $newPhotoName, 'public');
            // $request->file('photo')->storeAs('public/images', $newPhotoName);
        } else {
            // $emp = Medicine::query()->select('photo')->findOrFail($id)->first();
            $emp = Medicine::query()->select('photo')->where('id', $id)->first();
            // dd($emp);
            $newPhotoName = $emp->photo;
        }

        // store the data in the database patient table
        $medicine = Medicine::query()->where('id', $id)->update([
            'medicine_id' => $data['medicine_id'],

            'name' => $data['name'],
            'manufacturer' => $data['manufacturer'],
            'type' => $data['medicine_type'],

            'package_type' => $data['pakage_type'],
            'mesurement' => $data['mesurement'],
            'mesurement_value' => $data['mesurement_value'],
            'quantity' => $data['quantity'],

            'photo' => $newPhotoName,
            'batch_no' => $data['batch_no'],
            'description' => $data['description'],

            'expired_date' => $data['expired_date'],
        ]);

        // also insert batch medicine
        $batch = BatchMedicine::query()->where('batch_id', $data['batch_no'])->update([
            'batch_id' => $data['batch_no'],
            'batch_title' => $data['batch_title'],
            'medicine_id' => $data['medicine_id'],
            'stock_date' => $data['stock_date'],
            'expired_date' => $data['expired_date'],
        ]);


        // get the input data required
        // $request->validate([
        //     'medicine_id' => 'required',
        //     'name' => 'required',
        //     'quantity' => 'required',
        //     'expired_date' => 'required',
        // ]);

        // $data = $request->all();
        // // dd($data);

        // // update the information of the medicine
        // $medicine = Medicine::query()->where('id', $id)->update([
        //     'medicine_id' => $data['medicine_id'],
        //     'name' => $data['name'],
        //     // 'type' => '',
        //     'quantity' => $data['quantity'],
        //     'expired_date' => $data['expired_date'],
        // ]);

        // redirect back
        return redirect()->route('medicine.index')->with('success', 'Medicine Updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // find and deletes the image of the employee
        $this->delete_image($id);

        //deletes the record in the database
        $deleted_medicine = Medicine::query()->where('id', $id)->delete();

        // get the medicine records
        $medicines = Medicine::query()->latest()->paginate(16);

        // redirect to the index
        return redirect()->route('medicine.index')->with('success', 'Medicine Remove.')->with('medicines', $medicines);
    }

    public function delete_image($id)
    {
        //gets the meds to be deleted
        $medicine = Medicine::query()->where('id', $id)->first();

        // deletes the photo
        $destination = "storage\medicine img\\" . $medicine->photo;
        // $destination = public_path() . "storage/images/" . $emp->profile_pic;
        // dd($destination);

        if (File::exists($destination) && $medicine->photo != 'aclc500px.png') {
            // delete the picture from the directory
            File::delete($destination);
            // dd('File deleted.');
        }
    }
}
