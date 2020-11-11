@extends('layouts.layout')

@section('content')
<?php 
    $privilegeArr = isset( $result['privileges']['display_name'])? $result['privileges']['display_name']:array();
    //dd($privilegeArr);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vessel</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Vessel</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->
  @if($status!='failed')
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 ">
                         <!-- @if(in_array('ADD',$privilegeArr))
                            <span  id="btnVesselsAdd" class="tooltips float-right" data-toggle="modal" data-target="#modal-vessels" data-placement="top" title="Add Vessel" style="cursor: pointer;">
                            <i class="fas fa-3x fa-plus-circle tooltips text-primary"></i>
                        </span> 
                         @endif
                    </div></br></br></br> -->

                    <div class="card">
                            <div class="card-header border-0">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Vessels</h2>
                            </div>
                            <div class="action-area">
                                
                               
                                <form action="{{url('csv-export')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="key" value = "Vessel">
                                    <button  type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                </form>
                                <button id="btnVesselsAdd" data-toggle="modal" data-target="#modal-vessels" type="button" class="btn btn-success tooltips " ><i class="fa fa-plus"></i> Add New Vessel</button>
                               
                            </div> 
                            </div>
                            </div>
                           
                    <div class="col-md-12 table p-4">
                        <table id="dtVessel" class="table  table-striped">
                            <thead align="center">
                                <tr>
                                    <th>Vessel</th>
                                    <th>Description</th>
                                    <th>LOA</th>
                                    <th>Beam</th>
                                    <th>Draft</th>
                                    <th hidden="">Action</th>
                                    <th>Action</th>
                                    
                                </tr>
                            </thead>
                            <tbody align="center">
                            @foreach($result['vessel'] as $result)
                            <tr>
                                <td>{{ $result->name }}</td>                                    
                                <td>{{ $result->description }}</td>   
                                <td>{{ $result->loa }}</td>   
                                <td>{{ $result->beam }}</td>   
                                <td>{{ $result->draft }}</td>
                                <td hidden="">{{ $result->id }}</td>    
                                <td align="center">
                                        <i class='fas fa-edit text-success fa-2x  tooltips edit' data-placement='top' title='Update Vessel' style='cursor:pointer'></i> &nbsp;&nbsp;
                                        <i class='fas fa-trash fa-2x  text-danger tooltips delete' data-placement='top' title='Delete Vessel' style='cursor:pointer'></i>
                                </td>  
                                      
                             </tr>
                            @endforeach  
                            </tbody>
                        </table>
                    </div>
                    <!-- /.2nd Row End -->
                </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
            <!--  Vessels Modal for ADD/EDIT -->
            <div class="modal fade" id="modal-vessels">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="mdlVesselsTitle">Add Vessel</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <form id="frmVessels" name="frmVessels">
                                <input type="hidden" id="id" name="id">
                                <div class="form-group">
                                    <label for="VesselsInput">Vessel <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Vessel">
                                </div>
                                <div class="form-group">
                                    <label for="DescriptionInput">Description</label>
                                    <textarea type="text" class="form-control " id="description" name="description" placeholder="Enter Description"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="LOAInput">LOA </label>
                                    <input type="text" class="form-control" id="loa" name="loa" placeholder="Enter LOA">
                                </div>
                                <div class="form-group">
                                    <label for="BeamInput">Beam</label>
                                    <input type="text" class="form-control" id="beam" name="beam" placeholder="Enter Beam">
                                </div>
                                <div class="form-group">
                                    <label for="DraftInput">Draft</label>
                                    <input type="text" class="form-control" id="draft" name="draft" placeholder="Enter Draft">
                                </div>
                                <div class="modal-footer justify-content">
                                    <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
                                    <button type="Submit" class="icon-button" data-placement="top"  id="btnVesselsSubmit" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.Vessels Modal -->
        </div>
    </section>
    <!-- /.content -->
    @endif
</div>
<!-- /.content-wrapper -->
@endsection

@push('script')
<script src="{{js('vessel_js')}}"></script>
@endpush