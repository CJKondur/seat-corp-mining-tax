@extends('web::layouts.grids.8-4')

@section('title', trans('corpminingtax::global.browser_title'))

@push('head')
    <link rel="stylesheet" type="text/css" href="{{ asset('web/css/corpminingtax.css') }}"/>
@endpush

@section('left')
    <div class="col-xs-12 col-sm-6">
    <div class="card">
        <div class="card-body">
            <div class="position-relative mb-4">
                <canvas id="x-chart" height="300" width="800"></canvas>
            </div>
        </div>
    </div>
    </div>
@stop
@push('javascript')
    <script type="text/javascript">
        $(document).ready(function(){

            const DATA_COUNT = 7;
            const NUMBER_CFG = {count: DATA_COUNT, min: -100, max: 100};

            const labels = Utils.months({count: 7});
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Dataset 1',
                        data: Utils.numbers(NUMBER_CFG),
                        borderColor: Utils.CHART_COLORS.red,
                        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.red, 0.5),
                    },
                    {
                        label: 'Dataset 2',
                        data: Utils.numbers(NUMBER_CFG),
                        borderColor: Utils.CHART_COLORS.blue,
                        backgroundColor: Utils.transparentize(Utils.CHART_COLORS.blue, 0.5),
                    }
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Chart.js Bar Chart'
                        }
                    }
                },
            };

            new Chart(document.getElementById('x-chart'), config)
        });
    </script>
@endpush