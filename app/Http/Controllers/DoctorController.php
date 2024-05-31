<?php

namespace App\Http\Controllers;

use App\Models\DespenseMedicine;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::query()->paginate(16);
        
        return view('doctor.list', compact('doctors'));
    }

    public function search_doctor(Request $request)
    {
        // get the data
        if ($request->ajax()) {
            $doctors = Doctor::query()->where('full_name', 'like', '%' . $request->key . '%')->orWhere('license_no', 'like', $request->key . '%')->get();
        }

        return view("components.doctor-search-list", compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('doctor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'license_no' => 'required|unique:doctors,license_no',
            'full_name' => 'required|unique:doctors,full_name',
        ]);

        $data = $request->all();

        // store the data in the database user table
        Doctor::query()->create([
            'license_no' => $data['license_no'],
            'full_name' => $data['full_name'],
            'description' => $data['description'],
        ]);

        // redirect back
        return redirect()->route('doctors.index')->with('success', 'New Doctor Added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::query()->where('id', $id)->first();

        // $despensed_medicines = DespenseMedicine::query()->join('medicines', 'despense_medicines.medicine', '=', 'medicines.medicine_id')->where('doctor', '=', $doctor->license_no)->get();

        // $despensed_medicines = DespenseMedicine::query()->selectRaw('despense_medicines.*, patients.*, medicines.*')->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.name')->get();

        $despensed_medicines = DespenseMedicine::query()->selectRaw('despense_medicines.*, patients.id AS p_id,  despense_medicines.quantity AS dm_q, patients.*, medicines.*')->where('doctor', $doctor->license_no)->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.medicine_id')->get();

        // dd($despensed_medicines);

        return view('doctor.details', compact('doctor', 'despensed_medicines'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //deletes the record in the database
        $doctor = Doctor::query()->where('id', $id)->delete();

        // redirect to the index
        return redirect()->route('doctors.index')->with('success', 'Doctor Remove.');
    }
}
