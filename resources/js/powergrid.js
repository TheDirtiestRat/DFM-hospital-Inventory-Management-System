// powergrid livewire
import './../../vendor/power-components/livewire-powergrid/dist/powergrid';
// If you use Bootstrap 5 
import './../../vendor/power-components/livewire-powergrid/dist/bootstrap5.css';

// alpine (im just importing this so that it works with the livewire powergrid)
import Alpine from 'alpinejs';
 
window.Alpine = Alpine;
 
Alpine.start();

import flatpickr from "flatpickr";
window.flatpickr = flatpickr;

// import jquery
import jQuery from 'jquery';
window.$ = jQuery;