@extends('layouts.layout')

@section('content')
<!-- Content Wrapper. Contains page content -->
<link rel="stylesheet" href="{{css('dashboard_css')}}">


<div class="content-wrapper">
    @if (\Session::has('success'))
    <div class="alert alert-success">
        {!! \Session::get('success') !!}
    </div>
    @endif
    @if (\Session::has('error'))
    <div class="alert alert-danger">
        {!! \Session::get('error') !!}
    </div>
    @endif

    <div class="container-fluid">

        <div class="row">
            <div class="filterArea">
                <form id="filterForm" style="margin-top: 0.5rem">

                    <h5 class="m-0">Filter</h5>

                    <div class="dashboard-filter-content">
                        <div class="input-group">
                            <input type="text" id="plotDate" name="filter.plotDate" class="form-control datetimepicker-input" />
                            <div class="input-group-append datetimepicker" data-target="#plotDate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                    <div class="dashboard-filter-content">
                        <select class="multiselect" multiple="multiple" id="cmbVessel" name="filter.cmbVessel[]" data-placeholder="Select Vessel" style="width: 100%;">
                            <!-- <option value="all" selected="selected">All Vessel</option> -->
                            @foreach($result[0]['vessel'] as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>



                    </div>
                    <div class="dashboard-filter-content">
                        <select class="multiselect" multiple="multiple" data-placeholder="Select Customer" style="width: 100%;" id="cmbCustomer" name="filter.cmbCustomer[]">
                            <!-- <option value="all" selected="selected">All Customer</option> -->
                            @foreach($result[2]['data'] as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="dashboard-filter-content">
                        <select class="multiselect" multiple="multiple" data-placeholder="Select Cargo" style="width: 100%;" id="cmbCargo" name="filter.cmbCargo[]">
                            <!-- <option value="all" selected="selected">All Cargo</option> -->
                            @foreach($result[1]['cargo'] as $data)
                            <option value="{{ $data->id }}">{{ $data->name }}</option>
                            @endforeach
                        </select>
                    </div>









                </form>
            </div>
            <div title="Filter" class="filterBtn float">
                <span class="bg-danger filter-notification">0</span>
                <i class="fa fa-filter  my-float" aria-hidden="true"></i>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card-header border-0 col-md-12">
                    <div class="header-details dashboard-filter bg-navy">
                        <span>Berth to Plot </span>
                        <img class="img img-reponsive" src="{{url('custom/icons/berthtoplot.png')}}">

                    </div>
                    <div class="header-details dashboard-filter p-0">

                        <table class="table" style="width: 100%;">
                            <thead class="bg-grey">
                                <th>Shift</th>
                                <th>No Of Trucks</th>
                                <th>Trips Completed</th>
                            </thead>
                            <tbody id="btp">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card-header border-0 col-md-12">
                    <div class="header-details dashboard-filter bg-navy">
                        <span>Plot to Plot</span>
                        <img class="img img-reponsive" src="{{url('custom/icons/plottoplot.png')}}">

                    </div>
                    <div class="header-details dashboard-filter p-0">

                        <table class="table" style="width: 100%;">
                            <thead class="bg-grey">
                                <th>Shift</th>
                                <th>No Of Trucks</th>
                                <th>Trips Completed</th>
                            </thead>
                            <tbody id="ptp">


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card-header border-0 col-md-12">
                    <div class="header-details dashboard-filter bg-navy">
                        <span>No of Trucks </span>
                        <img class="img img-reponsive" src="{{url('custom/icons/nooftrucks.png')}}">

                    </div>
                    <div class="header-details dashboard-filter">
                        <div class="col-md-8">
                            <p><span class="text-label-1">Shift A</span> : <span class="default grapharea-nooftrucks-A">0</span></p>
                            <p><span class="text-label-2">Shift B</span> : <span class="default grapharea-nooftrucks-B">0</span></p>
                            <p><span class="text-label-3">Shift C</span> : <span class="default grapharea-nooftrucks-C">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <canvas id="grapharea-nooftrucks" width="100%" height="100%"></canvas>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card-header border-0 col-md-12">
                    <div class="header-details dashboard-filter bg-navy">

                        <span>Trips Completed </span>
                        <img class="img img-reponsive" src="{{url('custom/icons/tripscompleted.png')}}">


                    </div>
                    <div class="header-details dashboard-filter">
                        <div class="col-md-8">
                            <p><span class="text-label-1">Shift A</span> : <span class="default grapharea-tripscompleted-A">0</span></p>
                            <p><span class="text-label-2">Shift B</span> : <span class="default grapharea-tripscompleted-B">0</span></p>
                            <p><span class="text-label-3">Shift C</span> : <span class="default grapharea-tripscompleted-C">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <canvas id="grapharea-tripscompleted" width="100%" height="100%"></canvas>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card-header border-0 col-md-12">
                    <div class="header-details dashboard-filter bg-navy">
                        <span>Challans Deposited </span>
                        <img class="img img-reponsive" src="{{url('custom/icons/challandep.png')}}">

                    </div>
                    <div class="header-details dashboard-filter">
                        <div class="col-md-8">
                            <p><span class="text-label-1">Shift A</span> : <span class="default grapharea-challansdep-A">0</span></p>
                            <p><span class="text-label-2">Shift B</span> : <span class="default grapharea-challansdep-B">0</span></p>
                            <p><span class="text-label-3">Shift C</span> : <span class="default grapharea-challansdep-C">0</span></p>
                        </div>
                        <div class="col-md-4">
                            <canvas id="grapharea-challansdep" width="100%" height="100%"></canvas>

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div>











@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<script type='text/javascript'>
    var token = '{{ csrf_token() }}';
</script>
<script src="{{ js('dashboard_js') }}"></script>
@endpush