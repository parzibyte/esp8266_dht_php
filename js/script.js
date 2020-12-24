new Vue({
    el: "#app",
    data: () => ({
        startTime: "",
        endTime: "",
        startDate: "",
        endDate: "",
        chart: null,
    }),
    async mounted() {
        this.startDate = this.getStartMonthDate();
        this.endDate = this.getEndMonthDate();
        this.endTime = this.getStartTime();
        this.startTime = this.getStartTime();
        await this.onDateOrTimeChanged();
    },
    methods: {
        async onDateOrTimeChanged() {
            const url = `http://localhost/esp8266_dht/get_data.php?start=${this.startDate.concat(" ", this.startTime)}&end=${this.endDate.concat(" ", this.endTime)}`;
            const response = await fetch(url);
            const log = await response.json();
            const labels = log.map(d => {
                return d.date;
            });
            const temperatureData = log.map(d => {
                return d.temperature;
            });
            const humidityData = log.map(d => {
                return d.humidity;
            });
            this.refreshChart(labels, temperatureData, humidityData);
        },
        getStartMonthDate() {
            const d = new Date();
            return this.formatDate(new Date(d.getFullYear(), d.getMonth(), 1));
        },
        getEndMonthDate() {
            const d = new Date();
            return this.formatDate(new Date(d.getFullYear(), d.getMonth() + 1, 0));
        },
        getStartTime() {
            const d = new Date();
            return this.formatTime(new Date(d.getFullYear(), d.getMonth(), d.getDate(), 0, 0, 0));
        },
        formatDate(date) {
            const month = date.getMonth() + 1;
            const day = date.getDate();
            return `${date.getFullYear()}-${this.padWithZero(month)}-${this.padWithZero(day)}`;
        },
        formatTime(date) {
            const hours = date.getHours();
            const minutes = date.getMinutes();
            const seconds = date.getSeconds();
            return `${this.padWithZero(hours)}:${this.padWithZero(minutes)}:${this.padWithZero(seconds)}`;
        },
        padWithZero(value) {
            return (value < 10 ? "0" : "").concat(value);
        },
        refreshChart(labels, temperatureData, humidityData) {
            if (this.chart) {
                this.chart.destroy();
            }
            this.chart = new Chart(document.querySelector("#chart"), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Temperature',
                        data: temperatureData,
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                        ],

                        pointRadius: 1,
                        pointHoverRadius: 1
                    },
                    {
                        label: 'Humidity',
                        data: humidityData,
                        backgroundColor: [
                            'rgba(54, 162, 235, 0.2)',
                        ],
                        pointRadius: 1,
                        pointHoverRadius: 1
                    }
                    ]
                },
                options: {

                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }],

                        xAxes: [{
                            display: false //this will remove all the x-axis grid lines
                        }]
                    },
                }
            });
        },
    },
});