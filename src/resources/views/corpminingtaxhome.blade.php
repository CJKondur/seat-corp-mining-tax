@extends('web::layouts.grids.12')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('full')
    <div class="row">
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-yellow elevation-1"><i class="fa fa-dice-d20"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined Quantity <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($minings->mined_total_quantity) }} <small>units</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-red elevation-1"><i class="fa fa-gem"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined Volume <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($minings->mined_total_volume) }} <small>m³</small>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-6">
            <div class="info-box">
                <span class="info-box-icon bg-green elevation-1"><i class="fa fa-coins"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Mined ISK <small>(last 12 month's)</small></span>
                    <span class="info-box-number">
                        {{ number_format($minings->mined_total_price) }} <small>ISK</small>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining performance last 12 month`s</h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mining volume per Group</h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart2"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mined Ore by type (last 12 month's)</h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <canvas id="mining_chart3"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Debug Window</h3>
                </div>
                <div class="card-body">
                    <div style="height: 350px">
                        <p>{{ $dataset }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">

        var chart_labels = @json($minings->labels);
        var chart_data = @json($minings->volume_per_month);

        const data = {
            labels: chart_labels,
            datasets: [{
                label: 'Volume m³',
                data: chart_data,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    ],
                borderColor: [
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
                    'rgb(255, 99, 132)',
        ],
            borderWidth: 1
        }]
        };
        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };

        new Chart(document.getElementById('mining_chart').getContext('2d'), config);

        const data2 = {
            labels: chart_labels,
            datasets: [ {!! $dataset !!}]
            ,
        };
        const config2 = {
            type: 'bar',
            data: data2,
            options: {
                tooltips: {
                    displayColors: true,
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    xAxes: [{
                        stacked: true,
                    }],
                    yAxes: [{
                        stacked: true,
                        ticks: {
                            beginAtZero: true,
                        },
                    }]
                }
            },
        };
        new Chart(document.getElementById('mining_chart2').getContext('2d'), config2);

        const data3 = {
            labels: ['Mexcorit', 'Thick Blue Ice', 'Arkonor', 'Lavish Cinnabar', 'Cinnabar', 'Sylvite', 'Chromite'],
            datasets: [{
                axis: 'y',
                label: '',
                data: [1000,5222,908,3200,4000,5200,4800],
                fill: false,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                    'rgba(255, 99, 132, 0.9)',
                ],
            }]
        };
        const config3 = {
            type: 'horizontalBar',
            data: data3,
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        };
        new Chart(document.getElementById('mining_chart3').getContext('2d'), config3);

    </script>
@endpush