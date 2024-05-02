import Chart from 'chart.js/auto';

(async function () {
    const in_label = line_label;
    const input = line_data;

    const labels = input.map(row => row.label);
    const data = {
        labels: labels,
        datasets: [{
            label: in_label,
            data: input.map(row => row.value),
            fill: false,
            borderColor: '#0d6efd',
            backgroundColor: '#0d6efd',
            tension: 0.1
        },
            // {
            //     label: 'Discharge Patients',
            //     data: line_data_discharge,
            //     fill: false,
            //     borderColor: '#20c997',
            //     backgroundColor: '#20c997',
            //     tension: 0.1
            // }
        ]
    };

    new Chart(
        document.getElementById('lineChart'),
        {
            type: 'line',
            data: data,
            options: {
                // animation: false
            }
        }
    );
})();
