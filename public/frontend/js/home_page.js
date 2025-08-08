let won = document.currentScript.getAttribute('data-won');
const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
const data = {
    labels: labels,
    datasets: [{
        label: ['Win'],
        backgroundColor: 'rgb(255, 99, 132)',
        borderColor: 'rgb(255, 99, 132)',
        data: JSON.parse(won),
    }]
};
const config = {
    type: 'line',
    data: data,
    options: {
        animations: {
            tension: {
                duration: 1000,
                easing: 'linear',
                from: 1,
                to: 0,
                loop: true
            }
        },
    }
};
const myChart = new Chart(
    document.getElementById('myChart'),
    config
);