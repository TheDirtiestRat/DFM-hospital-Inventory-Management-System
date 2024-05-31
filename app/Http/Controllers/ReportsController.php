<?php

namespace App\Http\Controllers;

use App\Models\AssistanceRequest;
use App\Models\DespenseMedicine;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCase;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function dashboard()
    {
        // get total arival patients by weekday
        // $arrival_by_weekdays = array(
        //     '0' => '',
        //     '1' => '',
        //     '2' => '',
        //     '3' => '',
        //     '4' => '',
        //     '5' => '',
        //     '6' => '',
        // );
        // // get all total arrival patients
        // $total_arrival_patients = 0;
        // // get total arrival by week
        // $total_by_week_arrival_patients = DB::query()->selectRaw('weekday(`created_at`) AS week_day, count(`id`) as total FROM `patients` GROUP BY week_day ORDER BY week_day ASC')->get();
        // for ($i = 0; $i < count($arrival_by_weekdays); $i++) {
        //     for ($j = 0; $j < count($total_by_week_arrival_patients); $j++) {
        //         if ($total_by_week_arrival_patients[$j]->week_day == $i) {
        //             $arrival_by_weekdays[$i] = $total_by_week_arrival_patients[$j]->total;
        //             $total_arrival_patients += $total_by_week_arrival_patients[$j]->total;
        //         }
        //     }
        // }
        // // get total discharge patients by weekday
        // $discharge_by_weekdays = array(
        //     '0' => '11',
        //     '1' => '23',
        //     '2' => '4',
        //     '3' => '5',
        //     '4' => '10',
        //     '5' => '2',
        //     '6' => '13',
        // );
        // get the total of patient by diagnosis
        // $total_by_diagnosis = DB::query()->selectRaw('`diagnosis`, count(`case_no`) as total FROM `patient_cases` GROUP BY `diagnosis` ORDER BY total DESC LIMIT 5')->get();
        // $total_by_requestAssistance = DB::query()->selectRaw('`request_type`, count(`case_no`) as total FROM `assistance_requests` GROUP BY `request_type` ORDER BY total DESC LIMIT 5')->get();

        // get total medicine
        $total_medicine = Medicine::query()->count();
        // get total of patient listed
        $total_patients = Patient::query()->count();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
        // get total users
        $total_users = User::query()->count();
        // get total medicine quantity
        $total_quantity = Medicine::query()->sum('quantity');
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->count();
        // total by medicine despense each day
        $total_despense_meds = DespenseMedicine::query()->selectRaw('DATE(`created_at`) AS day, count(`medicine`) as total')->groupBy('day')->limit(7)->get();

        // get total of request
        // $total_request = AssistanceRequest::query()->count();
        // get request total by status
        // $total_approve_request = AssistanceRequest::query()->where('status', '=', 'APPROVE')->count();
        // $total_pending_request = AssistanceRequest::query()->where('status', '=', 'PENDING')->count();
        // $total_regected_request = AssistanceRequest::query()->where('status', '=', 'REJECT')->count();

        // get expiration of meds
        $exp_meds = Medicine::query()->selectRaw('datediff(`expired_date`, date(`created_at`)) AS datediff')->get();
        $exp_m_arry = array();

        foreach ($exp_meds as &$value) {
            array_push($exp_m_arry, $value->datediff);
        }

        $counted_meds = array_count_values($exp_m_arry);
        $not_expired = 0;
        $expired = 0;
        foreach ($counted_meds as $key => $value) {
            if ($key >= 30) {
                $not_expired += $value;
                // array_push($not_expired, $value);
            } else if ($key <= 0) {
                $expired += $value;
                // array_push($expired, $value);
            }
        }

        // dd($total_arrival_patients);

        return view('pages.dashboard', compact(
            'total_users',
            'total_patients',
            'total_quantity',
            'total_medicine',

            'total_by_gender',
            'total_despense_meds',

            'good_stock',
            'low_stock',
            'out_of_stock',

            'not_expired',
            'expired',
        ));
    }

    public function receptionist_dashboard()
    {
        // get total of patient listed
        $total_patients = Patient::query()->count();
        // total of patients base by diagnosis
        $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->groupBy('diagnosis')->limit(6)->get();
        // get newly added patients
        $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.created_at')->limit(4)->get();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();

        // get total by age groups
        $child = Patient::query()->whereBetween('age', [1, 10])->count();
        $teen = Patient::query()->whereBetween('age', [11, 20])->count();
        $adult = Patient::query()->whereBetween('age', [21, 59])->count();
        $old = Patient::query()->whereBetween('age', [60, 100])->count();

        // dd($teen);

        return view('pages.dashboard-receptionist', compact(
            'patients',
            'total_by_gender',
            'total_patients',
            'total_by_diagnosis',

            'child',
            'teen',
            'adult',
            'old',
        ));
    }

    public function pharmacist_dashboard()
    {
        // get total's
        $total_medicine = Medicine::query()->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
        $total_quantity = Medicine::query()->sum('quantity');
        // get the medicine records
        $medicines_despense = DespenseMedicine::query()->groupBy('medicine')->latest()->get('medicine');
        $medicines = Medicine::query()->whereIn('name', $medicines_despense)->limit(4)->get();
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->count();

        // dd($most_despense);

        return view('pages.dashboard-pharmacist', compact(
            'medicines',
            'total_medicine',
            'total_despensed',
            'total_quantity',
            'good_stock',
            'low_stock',
            'out_of_stock',
        ));
    }

    public function reports()
    {
        // get total of patient listed
        $total_patients = Patient::query()->count();
        // get total users
        $total_users = User::query()->count();
        // get total medicine
        $total_medicine = Medicine::query()->count();
        // get total of request
        $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
        // total by medicine despense each day
        $total_despense_meds = DespenseMedicine::query()->selectRaw('DATE(`created_at`) AS day, count(`medicine`) as total')->groupBy('day')->limit(7)->get();

        // dd($total_by_gender);

        return view('pages.reports', compact(
            'total_despensed',
            'total_users',
            'total_patients',
            'total_by_gender',
            'total_medicine',
            'total_despense_meds',


        ));
    }

    public function patient_records_report(Request $request)
    {
        $month = 0;
        // $selected_month = month()
        $year = date('Y'); //for now will use the year today

        // if there is an input in monthly
        if ($request->month != null) {
            $month = $request->month;

            // get total of patient listed
            $new_patients = Patient::query()->latest()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->limit(5)->get(['id', 'case_no', 'first_name', 'mid_name', 'last_name', 'created_at']);
            // get total of patient listed
            $total_patients = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            // get total today added
            // $date_today = date('Y-m-d');
            $total_today = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            // $total_today = Patient::query()->whereRaw('DATE(`created_at`) = "' . $date_today . '"')->count();
            // get total of request
            $total_despensed = DespenseMedicine::query()->select('despensed')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->distinct()->count();
            // total of patients base by gender
            $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('gender')->get();
            // total of patients base by blood type
            $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('blood_type')->get();
            // total of patients base by diagnosis
            $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('diagnosis')->get();

            // get total by age groups
            $child = Patient::query()->whereBetween('age', [1, 10])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $teen = Patient::query()->whereBetween('age', [11, 20])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $adult = Patient::query()->whereBetween('age', [21, 59])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $old = Patient::query()->whereBetween('age', [60, 100])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();

            // get total by bmi groups
            $underweight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [0, 18.5])->count();
            $obesity = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [30, 500])->count();
            $normal_weight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [18.6, 24.9])->count();
            $overweight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [25, 29.9])->count();

            return view('pages.patientsReports', compact(
                'new_patients',
                'total_patients',
                'total_today',
                'total_despensed',
                'total_by_gender',
                'total_by_bloodType',
                'total_by_diagnosis',

                'child',
                'teen',
                'adult',
                'old',

                'month',

                'underweight',
                'obesity',
                'normal_weight',
                'overweight',
            ));
        }

        // get total of patient listed
        $new_patients = Patient::query()->latest()->limit(5)->get(['id', 'case_no', 'first_name', 'mid_name', 'last_name', 'created_at']);
        // get total of patient listed
        $total_patients = Patient::query()->count();
        // get total today added
        $date_today = date('Y-m-d');
        $total_today = Patient::query()->whereRaw('DATE(`created_at`) = "' . $date_today . '"')->count();
        // get total of request
        $total_despensed = DespenseMedicine::query()->select('despensed')->distinct()->count();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
        // total of patients base by blood type
        $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->groupBy('blood_type')->get();
        // total of patients base by diagnosis
        $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->groupBy('diagnosis')->get();

        // get total by age groups
        $child = Patient::query()->whereBetween('age', [1, 10])->count();
        $teen = Patient::query()->whereBetween('age', [11, 20])->count();
        $adult = Patient::query()->whereBetween('age', [21, 59])->count();
        $old = Patient::query()->whereBetween('age', [60, 100])->count();
        // dd($total_despensed);

        // get total by bmi groups
        $underweight = Patient::query()->whereBetween('BMI', [0, 18.5])->count();
        $obesity = Patient::query()->whereBetween('BMI', [30, 500])->count();
        $normal_weight = Patient::query()->whereBetween('BMI', [18.6, 24.9])->count();
        $overweight = Patient::query()->whereBetween('BMI', [25, 29.9])->count();

        return view('pages.patientsReports', compact(
            'new_patients',
            'total_patients',
            'total_today',
            'total_despensed',
            'total_by_gender',
            'total_by_bloodType',
            'total_by_diagnosis',

            'child',
            'teen',
            'adult',
            'old',
            'month',

            'underweight',
            'obesity',
            'normal_weight',
            'overweight',
        ));
    }

    public function printable_patient_report(Request $request)
    {
        $month = 0;
        // $selected_month = month()
        $year = date('Y'); //for now will use the year today

        // if there is an input in monthly
        if ($request->month != null) {
            $month = $request->month;

            // get total of patient listed
            $new_patients = Patient::query()->latest()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get(['id', 'case_no', 'first_name', 'mid_name', 'last_name', 'created_at']);
            // get total of patient listed
            $total_patients = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            // get total today added
            // $date_today = date('Y-m-d');
            $total_today = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            // $total_today = Patient::query()->whereRaw('DATE(`created_at`) = "' . $date_today . '"')->count();
            // get total of request
            $total_despensed = DespenseMedicine::query()->select('despensed')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->distinct()->count();
            // total of patients base by gender
            $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('gender')->get();
            // total of patients base by blood type
            $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('blood_type')->get();
            // total of patients base by diagnosis
            $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->groupBy('diagnosis')->get();

            // get total by age groups
            $child = Patient::query()->whereBetween('age', [1, 10])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $teen = Patient::query()->whereBetween('age', [11, 20])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $adult = Patient::query()->whereBetween('age', [21, 59])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $old = Patient::query()->whereBetween('age', [60, 100])->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();

            // get total by bmi groups
            $underweight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [0, 18.5])->count();
            $obesity = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [30, 500])->count();
            $normal_weight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [18.6, 24.9])->count();
            $overweight = Patient::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->whereBetween('BMI', [25, 29.9])->count();
        } else {
            // get total of patient listed
            $new_patients = Patient::query()->latest()->get(['id', 'case_no', 'first_name', 'mid_name', 'last_name', 'created_at']);
            // get total of patient listed
            $total_patients = Patient::query()->count();
            // get total today added
            $date_today = date('Y-m-d');
            $total_today = Patient::query()->whereRaw('DATE(`created_at`) = "' . $date_today . '"')->count();
            // get total of request
            $total_despensed = DespenseMedicine::query()->select('despensed')->distinct()->count();
            // total of patients base by gender
            $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
            // total of patients base by blood type
            $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->groupBy('blood_type')->get();
            // total of patients base by diagnosis
            $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->groupBy('diagnosis')->get();

            // get total by age groups
            $child = Patient::query()->whereBetween('age', [1, 10])->count();
            $teen = Patient::query()->whereBetween('age', [11, 20])->count();
            $adult = Patient::query()->whereBetween('age', [21, 59])->count();
            $old = Patient::query()->whereBetween('age', [60, 100])->count();
            // dd($total_despensed);

            // get total by bmi groups
            $underweight = Patient::query()->whereBetween('BMI', [0, 18.5])->count();
            $obesity = Patient::query()->whereBetween('BMI', [30, 500])->count();
            $normal_weight = Patient::query()->whereBetween('BMI', [18.6, 24.9])->count();
            $overweight = Patient::query()->whereBetween('BMI', [25, 29.9])->count();
        }

        return view('printables.patientsReports', compact(
            'new_patients',
            'total_patients',
            'total_today',
            'total_despensed',
            'total_by_gender',
            'total_by_bloodType',
            'total_by_diagnosis',

            'child',
            'teen',
            'adult',
            'old',

            'month',

            'underweight',
            'obesity',
            'normal_weight',
            'overweight',
        ));
    }

    public function medicine_despensed_report(Request $request)
    {
        $month = 0;
        $year = date('Y'); //for now will use the year today

        if ($request->month != null) {
            $month = $request->month;

            $despensed_med = DespenseMedicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->latest()->limit(10)->get();
            $total_medicine = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $total_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->distinct()->count();
            $total_quantity = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->sum('quantity');
            // get stock by quantity
            $good_stock = Medicine::query()->where('quantity', '>', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $low_stock = Medicine::query()->where('quantity', '<=', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
            $out_of_stock = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();

            // get expiration of meds
            $exp_meds = Medicine::query()->selectRaw('datediff(`expired_date`, date(`created_at`)) AS datediff')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();
            // $exp_meds = Medicine::query()->selectRaw('(year(`expired_date`) - year(`created_at`)) AS datediff')->get();
            $exp_m_arry = array();

            foreach ($exp_meds as &$value) {
                array_push($exp_m_arry, $value->datediff);
            }

            // dd($exp_m_arry);

            $counted_meds = array_count_values($exp_m_arry);
            $not_expired = 0;
            $to_expired = 0;
            $expired = 0;
            foreach ($counted_meds as $key => $value) {
                if ($key >= 60) {
                    $not_expired += $value;
                    // array_push($not_expired, $value);
                } else if ($key <= 30) {
                    $to_expired += $value;
                } else if ($key <= 0) {
                    $expired += $value;
                    // array_push($expired, $value);
                }
            }
            // dd($counted_meds);

            $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();
        } else {
            $despensed_med = DespenseMedicine::query()->join("medicines", "medicines.medicine_id", "=", "despense_medicines.medicine")->latest("despense_medicines.created_at")->limit(10)->get();
            // dd($despensed_med);
            $total_medicine = Medicine::query()->count();
            $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
            $total_quantity = Medicine::query()->sum('quantity');
            // get stock by quantity
            $good_stock = Medicine::query()->where('quantity', '>', 100)->count();
            $low_stock = Medicine::query()->where('quantity', '<=', 100)->count();
            $out_of_stock = Medicine::query()->where('quantity', '=', 0)->count();

            // get expiration of meds
            $exp_meds = Medicine::query()->selectRaw('datediff(`expired_date`, date(`created_at`)) AS datediff')->get();
            // $exp_meds = Medicine::query()->selectRaw('(year(`expired_date`) - year(`created_at`)) AS datediff')->get();
            $exp_m_arry = array();

            foreach ($exp_meds as &$value) {
                array_push($exp_m_arry, $value->datediff);
            }

            // dd($exp_m_arry);

            $counted_meds = array_count_values($exp_m_arry);
            $not_expired = 0;
            $to_expired = 0;
            $expired = 0;
            foreach ($counted_meds as $key => $value) {
                if ($key >= 60) {
                    $not_expired += $value;
                    // array_push($not_expired, $value);
                } else if ($key <= 30) {
                    $to_expired += $value;
                } else if ($key <= 0) {
                    $expired += $value;
                    // array_push($expired, $value);
                }
            }
            // dd($expired);

            $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->get();
            // dd($total_today);
        }

        return view('pages.despensedMedsReports', compact(
            'despensed_med',
            'total_medicine',
            'total_despensed',
            'total_quantity',
            'good_stock',
            'low_stock',
            'out_of_stock',
            'out_of_stock_meds',

            'not_expired',
            'to_expired',
            'expired',

            'month',
        ));
    }

    public function get_medicine_report(Request $request)
    {
        $month = $request->month;
        // $selected_month = month()
        $year = date('Y'); //for now will use the year today

        // dd($year);

        $despensed_med = DespenseMedicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->latest()->limit(10)->get();
        $total_medicine = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->distinct()->count();
        $total_quantity = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->sum('quantity');
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();

        // get expiration of meds
        $exp_meds = Medicine::query()->selectRaw('datediff(`expired_date`, date(`created_at`)) AS datediff')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();
        // $exp_meds = Medicine::query()->selectRaw('(year(`expired_date`) - year(`created_at`)) AS datediff')->get();
        $exp_m_arry = array();

        foreach ($exp_meds as &$value) {
            array_push($exp_m_arry, $value->datediff);
        }

        // dd($exp_m_arry);

        $counted_meds = array_count_values($exp_m_arry);
        $not_expired = 0;
        $to_expired = 0;
        $expired = 0;
        foreach ($counted_meds as $key => $value) {
            if ($key >= 60) {
                $not_expired += $value;
                // array_push($not_expired, $value);
            } else if ($key <= 30) {
                $to_expired += $value;
            } else {
                $expired += $value;
                // array_push($expired, $value);
            }
        }
        // dd($expired);

        $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();
        // dd($total_today);

        return view('pages.despensedMedsReports', compact(
            'despensed_med',
            'total_medicine',
            'total_despensed',
            'total_quantity',
            'good_stock',
            'low_stock',
            'out_of_stock',
            'out_of_stock_meds',

            'not_expired',
            'to_expired',
            'expired',

            'month',
        ));
    }
    public function printable_medicine_report(Request $request)
    {
        $month = $request->month;
        // $selected_month = month()
        $year = date('Y'); //for now will use the year today

        // dd($year);

        $despensed_med = DespenseMedicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->latest()->get();
        $total_medicine = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->distinct()->count();
        $total_quantity = Medicine::query()->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->sum('quantity');
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->count();

        // get expiration of meds
        $exp_meds = Medicine::query()->selectRaw('datediff(`expired_date`, date(`created_at`)) AS datediff')->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();
        // $exp_meds = Medicine::query()->selectRaw('(year(`expired_date`) - year(`created_at`)) AS datediff')->get();
        $exp_m_arry = array();

        foreach ($exp_meds as &$value) {
            array_push($exp_m_arry, $value->datediff);
        }

        // dd($exp_m_arry);

        $counted_meds = array_count_values($exp_m_arry);
        $not_expired = 0;
        $to_expired = 0;
        $expired = 0;
        foreach ($counted_meds as $key => $value) {
            if ($key >= 60) {
                $not_expired += $value;
                // array_push($not_expired, $value);
            } else if ($key <= 30) {
                $to_expired += $value;
            } else {
                $expired += $value;
                // array_push($expired, $value);
            }
        }
        // dd($expired);

        $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->whereRaw('month(`created_at`) = ' . $month . ' and year(`created_at`) = ' . $year)->get();

        return view('printables.MedicineReports', compact(
            'despensed_med',
            'total_medicine',
            'total_despensed',
            'total_quantity',
            'good_stock',
            'low_stock',
            'out_of_stock',
            'out_of_stock_meds',

            'not_expired',
            'to_expired',
            'expired',
        ));
    }

    public function print_pdf_patients_list()
    {
        $day_today = date('m-d-Y');
        $patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.created_at')->get(['patients.case_no', 'patients.first_name', 'patients.mid_name', 'patients.last_name', 'patient_cases.diagnosis', 'patients.created_at',]);

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.patient_list', compact('patients', 'img_logo'));
        // download the pdf
        // return $pdf->download($day_today . '_patientList.pdf');
        // then stream it
        return $pdf->stream();
    }

    public function print_pdf_medicines_list()
    {
        $medicines = Medicine::query()->latest()->get();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.medicine_list', compact('medicines', 'img_logo'));
        // then stream it
        return $pdf->stream();
    }

    public function print_pdf_despense_meds_list()
    {
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
            'medicines.name',

        ])->join('patients', 'despense_medicines.despensed', '=', 'patients.case_no')->join('medicines', 'despense_medicines.medicine', '=', 'medicines.medicine_id')->get();

        // dd($despensed_meds);

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.despense_meds_list', compact('despensed_meds', 'img_logo'));
        // then stream it
        return $pdf->stream();
    }

    public function print_pdf_patient_info_test(string $id)
    {
        $patient = Patient::query()->where('id', $id)->first();
        // get the patient cases
        $patient_case = PatientCase::query()->where('case_no', '=', $patient->case_no)->latest()->first();
        // get patitent request assistance
        $patient_assistances = AssistanceRequest::query()->where('case_no', '=', $patient->case_no)->get();
        // get patitent despensed medicines
        $despensed_medicines = DespenseMedicine::query()->selectRaw('medicine, sum(quantity) as total')->where('despensed', '=', $patient->case_no)->groupBy('medicine')->get();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        // $pdf = Pdf::loadView('pdf.despens_reciept', compact('patient', 'patient_case', 'patient_assistances', 'despensed_medicines', 'img_logo'));
        $pdf = Pdf::loadView('pdf.patient_info_sheet', compact('patient', 'patient_case', 'patient_assistances', 'despensed_medicines', 'img_logo'));
        // then stream it
        return $pdf->stream();
    }

    public function download_pdf_patient_info_test(string $id)
    {
        $patient = Patient::query()->where('id', $id)->first();
        // get the patient cases
        $patient_case = PatientCase::query()->where('case_no', '=', $patient->case_no)->first();
        // get patitent request assistance
        $patient_assistances = AssistanceRequest::query()->where('case_no', '=', $patient->case_no)->get();
        // get patitent despensed medicines
        $despensed_medicines = DespenseMedicine::query()->selectRaw('medicine, sum(quantity) as total')->where('despensed', '=', $patient->case_no)->groupBy('medicine')->get();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.patient_info_sheet', compact('patient', 'patient_case', 'patient_assistances', 'despensed_medicines', 'img_logo'));
        // then stream it
        return $pdf->download($patient->case_no . '_patientInfo.pdf');
    }

    public function print_pdf_medicines_reports()
    {
        // get overall total
        $total_medicine = Medicine::query()->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
        $total_quantity = Medicine::query()->sum('quantity');
        // added by today
        $date_today = date('Y-m-d');
        $added_medicine = Medicine::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->count();
        $added_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('date(`created_at`) = "' . $date_today . '"')->distinct()->count();
        $added_quantity = Medicine::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->sum('quantity');
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->count();

        // get medicine by stock
        $good_stock_meds = Medicine::query()->where('quantity', '>', 100)->get();
        $low_stock_meds = Medicine::query()->where('quantity', '<=', 100)->get();
        $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->get();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.medicine_reports', compact(
            // 'medicines',
            'img_logo',

            'total_medicine',
            'total_despensed',
            'total_quantity',

            'added_medicine',
            'added_despensed',
            'added_quantity',

            'good_stock',
            'low_stock',
            'out_of_stock',

            'good_stock_meds',
            'low_stock_meds',
            'out_of_stock_meds',
        ));
        // then stream it
        return $pdf->stream();
    }

    public function print_pdf_patientRecords_reports()
    {
        $date_today = date('Y-m-d');
        // get overall total
        $total_patient = Patient::query()->count();
        $total_today = Patient::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
        $added_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('date(`created_at`) = "' . $date_today . '"')->distinct()->count();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
        // total of patients base by blood type
        $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->groupBy('blood_type')->get();
        // total of patients base by diagnosis
        $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->groupBy('diagnosis')->get();
        // get total of patient listed
        $new_patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->whereRaw('MONTH(date(patients.created_at)) = "' . date('m') . '"')->latest('patients.created_at')->get();
        $recent_patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.updated_at')->get();

        // get total by age groups
        $child = Patient::query()->whereBetween('age', [1, 10])->count();
        $teen = Patient::query()->whereBetween('age', [11, 20])->count();
        $adult = Patient::query()->whereBetween('age', [21, 59])->count();
        $old = Patient::query()->whereBetween('age', [60, 100])->count();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.patients_reports', compact(
            // 'medicines',
            'img_logo',

            'total_patient',
            'total_today',
            'total_despensed',

            'added_despensed',
            'new_patients',
            'recent_patients',

            'total_by_gender',
            'total_by_bloodType',
            'total_by_diagnosis',

            'child',
            'teen',
            'adult',
            'old',
        ));
        // then stream it
        return $pdf->stream();
    }

    public function print_pdf_overall_reports()
    {
        $date_today = date('Y-m-d');
        // get overall total
        $total_patient = Patient::query()->count();
        $total_today = Patient::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->count();
        $total_despensed = DespenseMedicine::query()->select('medicine')->distinct()->count();
        $added_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('date(`created_at`) = "' . $date_today . '"')->distinct()->count();
        // total of patients base by gender
        $total_by_gender = Patient::query()->selectRaw('gender, count(case_no) as total')->groupBy('gender')->get();
        // total of patients base by blood type
        $total_by_bloodType = Patient::query()->selectRaw('blood_type, count(case_no) as total')->groupBy('blood_type')->get();
        // total of patients base by diagnosis
        $total_by_diagnosis = PatientCase::query()->selectRaw('diagnosis, count(case_no) as total')->groupBy('diagnosis')->get();
        // get total of patient listed
        $new_patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->whereRaw('MONTH(date(patients.created_at)) = "' . date('m') . '"')->latest('patients.created_at')->get();
        $recent_patients = Patient::query()->join('patient_cases', 'patients.case_no', '=', 'patient_cases.case_no')->latest('patients.updated_at')->get();

        // get overall total
        $total_medicine = Medicine::query()->count();

        $total_quantity = Medicine::query()->sum('quantity');
        // added by today
        $added_medicine = Medicine::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->count();
        $added_despensed = DespenseMedicine::query()->select('medicine')->whereRaw('date(`created_at`) = "' . $date_today . '"')->distinct()->count();
        $added_quantity = Medicine::query()->whereRaw('date(`created_at`) = "' . $date_today . '"')->sum('quantity');
        // get stock by quantity
        $good_stock = Medicine::query()->where('quantity', '>', 100)->count();
        $low_stock = Medicine::query()->where('quantity', '<=', 100)->count();
        $out_of_stock = Medicine::query()->where('quantity', '=', 0)->count();

        // get medicine by stock
        $good_stock_meds = Medicine::query()->where('quantity', '>', 100)->get();
        $low_stock_meds = Medicine::query()->where('quantity', '<=', 100)->get();
        $out_of_stock_meds = Medicine::query()->where('quantity', '=', 0)->get();

        // image logo
        $img_logo = public_path('storage/images/ormoc.png');

        // print by pdd
        $pdf = Pdf::loadView('pdf.overall_reports', compact(
            // 'medicines',
            'img_logo',

            'total_patient',
            'total_today',
            'total_despensed',

            'added_despensed',
            'new_patients',
            'recent_patients',

            'total_by_gender',
            'total_by_bloodType',
            'total_by_diagnosis',

            'total_medicine',
            'total_quantity',

            'added_medicine',
            'added_despensed',
            'added_quantity',

            'good_stock',
            'low_stock',
            'out_of_stock',

            'good_stock_meds',
            'low_stock_meds',
            'out_of_stock_meds',
        ));
        // then stream it
        return $pdf->stream();
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }

    public function goToNotification(string $n_id, string $type, string $i_val)
    {
        $a_user = Auth::user();
        $user = User::find($a_user->id);
        // dd($i_val);

        // read the notification selected
        $user->unreadNotifications()->where('id', '=', $n_id)->update(['read_at' => now()]);

        if ($type == 'patient') {
            return redirect()->route('patient.show', $i_val);
        } else {
            return redirect()->back();
        }
    }

    // public function deleteNotification()
    // {
    //     Auth::user()->unreadNotifications->markAsRead();
    //     return redirect()->back();
    // }
}
