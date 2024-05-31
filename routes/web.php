<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RequestAssistanceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/loginUser', [AuthenticationController::class, 'login_user']);

// authenticated users can access this routes
Route::middleware('auth')->group(function () {
    Route::delete('/logoutUser', [AuthenticationController::class, 'logout_user']);

    // homepage
    Route::get('/dashboard', [ReportsController::class, 'dashboard']);

    // receptionist routes
    Route::middleware('user.type:RECEPTIONIST,ADMIN')->group(function () {
        // dashboard
        Route::get('/dashboardReceptionist', [ReportsController::class, 'receptionist_dashboard']);
        // patient records
        Route::resource('patient', PatientController::class);
        Route::get('/patient_details', [PatientController::class, 'show_patient_partial_details']);
        Route::get('/patientsByBarangay', [PatientController::class, 'by_barangay']);

        // modal details
        Route::get('/barangay_details', [PatientController::class, 'barangay_detail_sum']);

        Route::get('/diagnosis_details', [PatientController::class, 'show_patient_diagnosis_details']);
        Route::get('/search_patient', [PatientController::class, 'search_patient_details']);

        Route::get('/sortPatient', [PatientController::class, 'sort_patient']);
        // diagnosis
        Route::post('/addNewDiagnosis', [PatientController::class, 'add_new_diagnosis']);

        // printables
        Route::get('/printPatientReports', [ReportsController::class, 'printable_patient_report']);
        Route::get('/printBarangayReports', [PatientController::class, 'printable_barangay_detail_summary']);
        // Route::get('/printBarangayReports', function () {
        //     dd('test');
        // });
    });


    // pharmacist routes
    Route::middleware('user.type:PHARMACIST,ADMIN')->group(function () {
        // dashboard
        Route::get('/dashboardPharmacist', [ReportsController::class, 'pharmacist_dashboard']);
        // medicine records
        Route::resource('medicine', MedicineController::class);
        Route::get('/MedicineByBatch', [MedicineController::class, 'create_by_batch']);
        Route::post('/storeByBatch', [MedicineController::class, 'store_batch']);
        Route::get('/ImportByBatch', [MedicineController::class, 'import_by_batch'])->name('ImportByBatch');
        Route::get('/medicine_details', [MedicineController::class, 'show_details']);
        Route::get('/search_medicine', [MedicineController::class, 'search_medicine']);

        Route::get('/goto_medicine/{id}', [MedicineController::class, 'goto_medicine']);

        Route::get('/despenseMedicine', [MedicineController::class, 'despense_medicine'])->name('despenseMedicine');
        Route::get('/despenseMedicineList', [MedicineController::class, 'despensed_meds_list']);
        Route::post('/despenseMedicineReciept', [MedicineController::class, 'despense_medicine_reciept']);
        Route::post('/recordDespenseMedicine', [MedicineController::class, 'record_despense_medicine']);

        Route::get('/getPatientToDespense', [MedicineController::class, 'get_patient_info']);
        Route::get('/getPatientDatalist', [MedicineController::class, 'get_patient_datalist']);

        // sortables
        // Route::get('/medicineReportsMonthly', [ReportsController::class, 'get_medicine_report']);

        // printables
        Route::get('/printMedicineReports', [ReportsController::class, 'printable_medicine_report']);
    });


    Route::middleware('user.type:ADMIN')->group(function () {
        // request freatures
        Route::resource('assistanceRequest', RequestAssistanceController::class);

        Route::resource('doctors', DoctorController::class);
        Route::get('/search_doctor', [DoctorController::class, 'search_doctor']);

        Route::get('/applyAssistanceRequest/{id}', [RequestAssistanceController::class, 'create']);
        Route::get('/getPatientInformation', [RequestAssistanceController::class, 'get_patient_information']);
        Route::get('/search_request', [RequestAssistanceController::class, 'search_assitance_request']);

        // reports
        Route::get('/reports', [ReportsController::class, 'reports']);
        // prints
        Route::get('/ReportsPDF', [ReportsController::class, 'print_pdf_overall_reports']);
    });

    // reports
    Route::middleware('user.type:RECEPTIONIST,ADMIN')->group(function () {
        Route::get('/patientList', [ReportsController::class, 'print_pdf_patients_list']);
        // print for physical copy test
        Route::get('/patientPDFInfo{id}', [ReportsController::class, 'print_pdf_patient_info_test'])->name('patientPDFInfo');
        // download the copy
        Route::get('/patientPDFDownload{id}', [ReportsController::class, 'download_pdf_patient_info_test'])->name('patientPDFDownload');

        // reports
        Route::get('/patientRecordsReport', [ReportsController::class, 'patient_records_report']);
        // prints
        Route::get('/patientRecordsReportsPDF', [ReportsController::class, 'print_pdf_patientRecords_reports']);
        
    });

    Route::middleware('user.type:PHARMACIST,ADMIN')->group(function () {
        // list pdf
        Route::get('/medicineList', [ReportsController::class, 'print_pdf_medicines_list']);
        Route::get('/despenseList', [ReportsController::class, 'print_pdf_despense_meds_list']);

        // get list of meds
        Route::get('/getMedicineList', [MedicineController::class, 'get_meds_list']);

        // import data
        Route::get('/importDataMedicines', function () {
            return view('medicine.import');
        });
        Route::post('/importMedsData', [MedicineController::class, 'import']);
        // export data
        Route::get('/exportData', [MedicineController::class, 'export']);
       
        // reports
        Route::get('/medicineRecordsReport', [ReportsController::class, 'medicine_despensed_report']);
        // prints
        Route::get('/medicineReportsPDF', [ReportsController::class, 'print_pdf_medicines_reports']);

        Route::get('/medicineRecieptPDF', [MedicineController::class, 'pdf_reciept_despense_medicine']);
        // Route::get('/medicineRecieptPDF/{id}{medicines}{quantities}', [MedicineController::class, 'pdf_reciept_despense_medicine'])->name('medicineRecieptPDF');
        
        Route::get('/test_listener', function () {
            return redirect('medicineReportsPDF');
        });
    });

    // user management
    // user management
    Route::resource('user', UserController::class, [
        'only' => ['index', 'create', 'store', 'destroy']
    ])->middleware('user.type:ADMIN');
    Route::resource('user', UserController::class, [
        'only' => ['show', 'edit', 'update']
    ])->middleware('user.type:PHARMACIST,RECEPTIONIST,ADMIN');

    // Route::resource('user', UserController::class);
    Route::get('/search_user', [UserController::class, 'search_users'])->middleware('user.type:ADMIN');

    // surprise
    Route::get('/I/Am/Very/Bored', function () {
        return view('pages.pong');
    })->middleware('user.type:ADMIN');

    Route::get('/when-leal-is-board', function () {
        return view('pages.brick-gm');
    })->middleware('user.type:ADMIN');

    // access by all (experimental)
    Route::get('/mark-as-read', [ReportsController::class, 'markAsRead'])->name('mark-as-read');
    // Route::get('/notifGoTo/{n_id}{go_to}', [ReportsController::class, 'goToNotification'])->name('notifGoTo');
    Route::name('go-to-notif')->get('/nofifId/{n_id}/urlLink/{type}/value/{i_val}', [ReportsController::class, 'goToNotification']);
});

// hi there, this is Leal your snooping to much in my code. Try not to fuck up everything right?
Route::post('/From_Leal', [AuthenticationController::class, 'my_birthday']);
