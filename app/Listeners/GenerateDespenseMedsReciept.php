<?php

namespace App\Listeners;

use App\Events\RecordDespenseMedicine;
use App\Http\Controllers\MedicineController;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\PatientCase;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateDespenseMedsReciept
{
    
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(RecordDespenseMedicine $event): void
    {
        // dd('despense medicine recorded ');
        // app('App\Http\Controllers\MedicineController')->pdf_reciept_despense_medicine($event->patient_id, $event->despensed_medicine, $event->medicine_quantity);
    }
}
