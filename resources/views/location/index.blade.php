@extends('layouts.layout')

@section('content')
<?php 
     $privilegeArr = isset( $result['privileges']['display_name'])? $result['privileges']['display_name']:array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Locations</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Locations</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->
  @if($status!='failed')
     <?php // dd($result);?>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">

                    <input type="hidden" id="location_id">        
                    <div class="col-md-12">
                    <div class="card">
                            <div class="card-header border-0">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Locations</h2>
                            </div>
                            <div class="action-area">
                                
                               
                                <form action="{{url('csv-export')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="key" value = "Location">
                                    <button  type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                </form>

                                <button id="btnLocationsAdd" type="button" class="btn btn-success tooltips " data-toggle="modal" data-target="#modal-locations" data-placement="top" ><i class="fa fa-plus"></i> Add New Location</button>
                               
                            </div> 
                            </div>
                            </div>

                         <!-- @if(in_array('ADD',$privilegeArr))
                            <span  id="btnLocationsAdd" class="float-right tooltips" data-toggle="modal"  style="cursor: pointer;">
                                <i class="fas fa-3x fa-plus-circle tooltips text-primary"></i>
                            </span>
                        @endif -->
                    
                    <!-- /.card-header -->
                    <div class="col-md-12 table p-4">
                        <table id="dtLocation" class="table  table-striped">
                            <thead align="center">
                                <tr>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th hidden="">Action</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody align="center">
                            @foreach($result['location'] as $result)
                            <tr>
                                <td>{{ $result->location }}</td>                                    
                                <td>{{ $result->description }}</td>                                                                        
                                <td>{{ $result->type == 'P'?'Plot':'Berth' }}</td>
                                <td hidden="">{{$result->id}}</td>    
                                <td align="center">

                                     <a href="javascript:void(0);" onclick="return editLocation('{{ $result->id }}')" data-target="top" class="edit tooltips" title="Update Location"><i class="fas fa-2x fa-edit text-success"></i></a> &nbsp;&nbsp;

                                     <i class='fas fa-2x fa-trash text-danger tooltips delete' data-placement='top' title='Delete Location' style='cursor:pointer'></i>

                                </td>                                 
                             </tr>
                            @endforeach  
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.row -->
            </div>
            </div>
            <!-- /.container-fluid -->
            <!--  Locations Modal for ADD/EDIT -->
            <div class="modal fade" id="modal-locations">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mdlLocationsTitle">Add Location</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="frmLocations" name="frmLocations">
                                <input type="hidden" id="hidden_id" name="id">
                                <div class="form-group">
                                    <label for="LocationsInput">Location <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control " id="location" name="location" placeholder="Enter Location">
                                </div>
                                <div class="form-group">
                                    <label for="DescriptionInput">Description</label>
                                    <textarea class="form-control " id="description" name="description" placeholder="Enter Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="TypeInput">Type <span class="text-danger">*</span></label>
                                    <div class="radio">
                                        <label for="TypeInputValue">
                                        <input type="radio" id="typeB" name="type"  value="B">  Berth
                                        <input type="radio" id="typeP" name="type"  value="P">  Plot
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content">
                                    <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
                                    <button type="Submit" class="icon-button" data-placement="top" id="btnLocationsSubmit" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.Locations Modal -->
        </div>
    </section>
    <!-- /.content -->
    @endif
</div>
<!-- /.content-wrapper -->
@endsection

@push('script')
<script src="{{js('location_js')}}"></script>
@endpush