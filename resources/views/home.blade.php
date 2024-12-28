@extends('layouts.app')

@section('content')
    @vite('resources/js/app_chart.js')
    <div class="container">
        <div class="card">
            <div class="row ">
                <div class="col-6">
                    <div id="chart-container" style="width:100%; height:400px;"></div>
                </div>
                <div class="col-6">
                    <div id="chart-container2" style="width:100%; height:400px;"></div>
                </div>
            </div>
        </div>

        <div class="row ">


            <div class="col-4">
                <div id="container" style="width:100%; height:400px;"></div>
            </div>
            <div class="col-4">
                <div id="container2" style="width:100%; height:400px;"></div>
            </div>
            <div class="col-4">
                <div id="container3" style="width:100%; height:400px;"></div>
            </div>


        </div>

    </div>
    </div>
    </div>
    </div>
@endsection
