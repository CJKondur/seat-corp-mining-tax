@extends('web::layouts.grids.8-4')

@section('title', 'Moonmining')

@section('left')
    <div class="card">
        <div class="card-header">
            <h3>Moon Mining Report</h3>
        </div>
        <div class="card-body">
            <div id="overlay" style="border-radius: 5px">
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <div class="spinner">
                    </div>
                </div>
            </div>
            <form action="{{ route('corpminingtax.moonminingdata') }}" method="post" id="moon" name="moon">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="mining_month">Mining Observer</label>
                        <select class="custom-select mr-sm-2" name="observer" id="observer">
                            @isset($data)
                            @foreach($data as $d)
                                <option value="{{ $d->observer_id }}">{{ $d->name }}</option>
                            @endforeach
                            @endisset
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="on()" type="submit">Send</button>
            </form>
        </div>
    </div>
    @isset($minings)
        <div class="card">
            <div class="card-header">
                <h4>{{ $name->name }}</h4>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Quantity</th>
                        <th>Volume</th>
                        <th>Mined Ore Types</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($minings as $m)
                        <tr>
                            <td>{{ $m->last_updated->format('d.m.Y') }}</td>
                            <td>{{ number_format($m->quantity,0,',','.') }}</td>
                            <td>{{ number_format($m->quantity*10,0,',','.') }} m³</td>
                            <td></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endisset
@stop