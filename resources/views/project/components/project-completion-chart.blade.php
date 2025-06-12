<div class="col-md-3">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-4 anchor" id="basic">Project Completion</h4>
            <div dir="ltr">
                <div id="basic-radialbar" class="apex-charts"></div>
            </div>
        </div>
        <!-- end card body-->
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var options = {
            chart: {
                height: 350,
                type: 'radialBar'
            },
            series: [67], // persentase progress (0–100)
            labels: ['Progress'],
            plotOptions: {
                radialBar: {
                    hollow: {
                        size: '70%'
                    },
                    dataLabels: {
                        name: {
                            fontSize: '18px',
                        },
                        value: {
                            fontSize: '32px',
                            fontWeight: 'bold',
                            color: '#000'
                        }
                    }
                }
            },
            colors: ['#20E647'], // warna radial
        };

        var chart = new ApexCharts(document.querySelector("#basic-radialbar"), options);
        chart.render();
    });
</script>
