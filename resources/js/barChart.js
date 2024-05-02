import Chart from 'chart.js/auto';

(async function () {
    const label = bar_label;
    const data = bar_data;

    new Chart(
        document.getElementById('barChart'),
        {
            type: 'bar',
            data: {
                labels: data.map(row => row.type),
                datasets: [
                    {
                        label: label,
                        data: data.map(row => row.count),
                        backgroundColor: '#0d6efd',
                    }
                ]
            }
        }
    );
})();
