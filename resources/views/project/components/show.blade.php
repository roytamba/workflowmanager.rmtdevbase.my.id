@extends('layouts.dashboard')
@push('styles')
@endpush
@section('content')
    <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
            <a class="nav-link fw-medium active" data-bs-toggle="tab" href="#post" role="tab" aria-selected="true">Overview</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-medium" data-bs-toggle="tab" href="#gallery" role="tab"
                aria-selected="false">Task</a>
        </li>
        <li class="nav-item">
            <a class="nav-link fw-medium " data-bs-toggle="tab" href="#settings" role="tab"
                aria-selected="false">Team</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-1 anchor" id="multi-series">Task Timeline</h4>

                    <div dir="ltr">
                        <div id="multi-series-timeline" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
        </div>
        <div class="col-md-4">
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
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data untuk timeline chart dengan detail task, person, dan durasi
            var options = {
                series: [{
                        name: 'John Doe',
                        data: [{
                                x: 'System Analysis',
                                y: [
                                    new Date('2024-01-01').getTime(),
                                    new Date('2024-01-15').getTime()
                                ],
                                fillColor: '#008FFB',
                                goals: [{
                                    name: 'Duration',
                                    value: 14,
                                    strokeHeight: 2,
                                    strokeColor: '#775DD0'
                                }]
                            },
                            {
                                x: 'Backend Development',
                                y: [
                                    new Date('2024-01-16').getTime(),
                                    new Date('2024-02-15').getTime()
                                ],
                                fillColor: '#008FFB'
                            }
                        ]
                    },
                    {
                        name: 'Jane Smith',
                        data: [{
                                x: 'UI/UX Design',
                                y: [
                                    new Date('2024-01-08').getTime(),
                                    new Date('2024-01-25').getTime()
                                ],
                                fillColor: '#00E396'
                            },
                            {
                                x: 'Frontend Development',
                                y: [
                                    new Date('2024-01-26').getTime(),
                                    new Date('2024-02-20').getTime()
                                ],
                                fillColor: '#00E396'
                            }
                        ]
                    },
                    {
                        name: 'Mike Johnson',
                        data: [{
                                x: 'Database Design',
                                y: [
                                    new Date('2024-01-10').getTime(),
                                    new Date('2024-01-20').getTime()
                                ],
                                fillColor: '#FEB019'
                            },
                            {
                                x: 'Testing & QA',
                                y: [
                                    new Date('2024-02-16').getTime(),
                                    new Date('2024-03-05').getTime()
                                ],
                                fillColor: '#FEB019'
                            }
                        ]
                    },
                    {
                        name: 'Sarah Wilson',
                        data: [{
                                x: 'Documentation',
                                y: [
                                    new Date('2024-02-21').getTime(),
                                    new Date('2024-03-10').getTime()
                                ],
                                fillColor: '#FF4560'
                            },
                            {
                                x: 'Deployment',
                                y: [
                                    new Date('2024-03-06').getTime(),
                                    new Date('2024-03-15').getTime()
                                ],
                                fillColor: '#FF4560'
                            }
                        ]
                    }
                ],
                chart: {
                    height: 350,
                    type: 'rangeBar'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        barHeight: '50%',
                        rangeBarGroupRows: true
                    }
                },
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                fill: {
                    type: 'solid'
                },
                xaxis: {
                    type: 'datetime'
                },
                legend: {
                    position: 'right',
                    markers: {
                        width: 16,
                        height: 16,
                        strokeWidth: 0,
                        strokeColor: '#fff',
                        fillColors: undefined,
                        radius: 3,
                        customHTML: undefined,
                        onClick: undefined,
                        offsetX: 0,
                        offsetY: 0
                    }
                },
                tooltip: {
                    custom: function(opts) {
                        const fromDate = new Date(opts.y1)
                        const toDate = new Date(opts.y2)
                        const fromDateStr = fromDate.toLocaleDateString('id-ID')
                        const toDateStr = toDate.toLocaleDateString('id-ID')

                        // Hitung durasi dalam hari
                        const timeDiff = toDate.getTime() - fromDate.getTime()
                        const dayDiff = Math.ceil(timeDiff / (1000 * 3600 * 24))

                        const currentData = opts.w.config.series[opts.seriesIndex].data[opts
                            .dataPointIndex];
                        const color = currentData.fillColor || '#000';
                        const seriesName = opts.w.globals.seriesNames[opts.seriesIndex];
                        const taskName = opts.w.globals.labels[opts.dataPointIndex]

                        return (
                            '<div class="apexcharts-tooltip-rangebar" style="padding: 10px; background: white; border: 1px solid #e0e0e0; border-radius: 6px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">' +
                            '<div style="margin-bottom: 8px;"><strong style="color: ' + color +
                            ';">👤 ' + seriesName + '</strong></div>' +
                            '<div style="margin-bottom: 6px;"><strong>📋 Task:</strong> <span style="color: #333;">' +
                            taskName + '</span></div>' +
                            '<div style="margin-bottom: 6px;"><strong>📅 Periode:</strong> <span style="color: #666;">' +
                            fromDateStr + ' - ' + toDateStr + '</span></div>' +
                            '<div><strong>⏱️ Durasi:</strong> <span style="color: #e74c3c; font-weight: bold;">' +
                            dayDiff + ' hari</span></div>' +
                            '</div>'
                        )
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#multi-series-timeline"), options);
            chart.render();
        });
    </script>
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
@endpush
