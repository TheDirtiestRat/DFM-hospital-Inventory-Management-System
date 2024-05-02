import Chart from 'chart.js/auto';

(async function () {
    const elem = (typeof pie_elem != 'undefined') ? pie_elem : 'pieChart';
    const label = pie_label;
    const input_data = pie_data;

    const data = {
        labels: input_data.map(row => row.type),
        datasets: [{
            label: label,
            data: input_data.map(row => row.total),
            backgroundColor: [
                '#6610f2',
                '#0d6efd',
                '#0dcaf0',
            ],
            hoverOffset: 4
        }]
    };

    new Chart(
        document.getElementById(elem),
        {
            type: 'doughnut',
            data: data,
        }
    );
})();
