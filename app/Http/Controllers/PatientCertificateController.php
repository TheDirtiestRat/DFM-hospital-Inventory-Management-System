<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\PatientCase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PatientCertificateController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => 'nullable|string|max:100',
            'patient' => 'nullable|integer|min:1',
        ]);

        $selectedPatient = isset($validated['patient'])
            ? Patient::query()->findOrFail($validated['patient'])
            : null;
        $search = trim($validated['search'] ?? '');

        if ($selectedPatient && $search === '') {
            $search = $selectedPatient->case_no;
        }

        $patients = Patient::query()
            ->select('patients.*')
            ->addSelect([
                'latest_diagnosis' => PatientCase::query()
                    ->select('diagnosis')
                    ->whereColumn('patient_cases.case_no', 'patients.case_no')
                    ->latest('created_at')
                    ->limit(1),
            ])
            ->when($search !== '', function (Builder $query) use ($search) {
                $nameTerms = preg_split('/\s+/', $search, -1, PREG_SPLIT_NO_EMPTY);

                $query->where(function (Builder $query) use ($search, $nameTerms) {
                    $query->where('patients.case_no', 'like', "%{$search}%")
                        ->orWhere(function (Builder $query) use ($nameTerms) {
                            foreach ($nameTerms as $term) {
                                $query->where(function (Builder $query) use ($term) {
                                    $query->where('patients.first_name', 'like', "%{$term}%")
                                        ->orWhere('patients.mid_name', 'like', "%{$term}%")
                                        ->orWhere('patients.last_name', 'like', "%{$term}%");
                                });
                            }
                        });
                });
            })
            ->latest('patients.created_at')
            ->paginate(12)
            ->withQueryString();

        return view('patient.certificates', [
            'patients' => $patients,
            'search' => $search,
            'selectedPatientId' => $selectedPatient?->id,
        ]);
    }

    public function print(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'type' => 'required|in:medical,death',
            'purpose' => 'required_if:type,medical|nullable|string|max:500',
            'death_date' => 'required_if:type,death|nullable|date|before_or_equal:today',
            'death_time' => 'required_if:type,death|nullable|date_format:H:i',
            'death_place' => 'required_if:type,death|nullable|string|max:255',
            'cause_of_death' => 'required_if:type,death|nullable|string|max:500',
            'certifier_name' => 'required_if:type,death|nullable|string|max:255',
            'certifier_license' => 'required_if:type,death|nullable|string|max:100',
        ]);

        $patientCase = PatientCase::query()
            ->where('case_no', $patient->case_no)
            ->latest('created_at')
            ->first();

        $img_logo = public_path('storage/images/ormoc.png');
        $certificateType = $validated['type'];
        $view = $certificateType === 'medical'
            ? 'pdf.medical_certificate'
            : 'pdf.death_certificate';

        $pdf = Pdf::loadView($view, [
            'patient' => $patient,
            'patientCase' => $patientCase,
            'certificateData' => $validated,
            'issuedAt' => now(),
            'img_logo' => $img_logo,
        ])->setPaper('a4', 'portrait');

        return $pdf->stream("{$certificateType}-certificate-patient-{$patient->id}.pdf");
    }
}
