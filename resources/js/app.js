import './bootstrap';

// Import our custom CSS
import '../sass/app.scss';
import '../css/app.css';
import '../css/styles.css';

// Import custom Javascript
import '../js/sidebar.js';

const showImageFallback = image => {
    if (!(image instanceof HTMLImageElement) || image.dataset.fallbackApplied) {
        return;
    }

    image.dataset.fallbackApplied = 'true';

    const fallback = document.createElement('span');
    fallback.className = `${image.className} image-fallback`;
    fallback.setAttribute('role', 'img');
    fallback.setAttribute('aria-label', image.alt || 'Image unavailable');
    fallback.style.width = `${image.width || 48}px`;
    fallback.style.height = `${image.height || 48}px`;

    const icon = document.createElement('i');
    icon.className = `bi ${image.dataset.fallbackIcon || 'bi-image'}`;
    icon.setAttribute('aria-hidden', 'true');
    fallback.append(icon);
    image.replaceWith(fallback);
};

document.addEventListener('error', event => {
    showImageFallback(event.target);
}, true);

for (const image of document.images) {
    if (image.complete && image.naturalWidth === 0) {
        showImageFallback(image);
    }
}

// import flatpickr from "flatpickr";
// window.flatpickr = flatpickr;

// import bootstrap from 'bootstrap';


// import jquery
import jQuery from 'jquery';
window.$ = jQuery;

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;


import Alert from 'bootstrap/js/dist/alert';

// or, specify which plugins you need:
import { Tooltip, Toast, Popover } from 'bootstrap';

// import flatpickr from "flatpickr";

// import '../js/tooltipScript.js';
// import chartjs script
// import '../js/barChart.js';
// import '../js/lineChart.js';