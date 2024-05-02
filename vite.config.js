import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/barChart.js',
                'resources/js/lineChart.js',
                'resources/js/pieChart.js',

                'resources/css/pongStyles.css',
                'resources/js/pongScript.js',

                'resources/js/powergrid.js',
            ],
            refresh: true,
        }),
        
    ],
    resolve: {
        alias: {
            '$': 'jQuery'
        }
    }
});
