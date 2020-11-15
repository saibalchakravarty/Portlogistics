$(document).ready(function () {
    //Vessel Datatable Rendering
    $("#dtVessel").DataTable({
        "order": [],
    });

    //Form validation
    $('input').on('keyup', function() {
        if ($("#frmRole").valid()) {
            $('#btnVesselsSubmit').prop('disabled', false);  
        } else {
            $('#btnVesselsSubmit').prop('disabled', 'disabled');
        }
    });

    //This is adding Regular Expression validation to element
    $.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');

    $("#frmVessels").validate({
        rules: {
            name: {
                required: true,
                maxlength: 50,
            },
            description: {
                maxlength: 150,
            },
            loa: {
                number: true,
            },
            beam: {
                number: true,
            },
            draft: {
                number: true,
            },
        },
        messages: {
            name: {
                required: "Please enter vessel",
                regex: "Vessel format is not valid",
                maxlength: "Vessel should not exceed 50 characters.",
            },
            description: {
                regex: "Description format is not valid",
                maxlength: "Description  should not exceed 150 characters.",
            },
            loa: {
                number: "Enter Decimal LOA",
                maxlength: "LOA  should not exceed 50 characters.",
            },
            beam: {
                number: "Enter Decimal Beam",
                maxlength: "Beam  should not exceed 50 characters.",
            },
            draft: {
                number: "Enter Decimal Draft",
                maxlength: "Draft  should not exceed 60 characters.",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("invalid-feedback");
            element.closest(".form-group").append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass("is-invalid");
            $(element).removeClass("is-valid");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },
        submitHandler: function (form) {
            var ajaxUrl = '';
            var type = '';
            if($("#id").val() != "") {
                ajaxUrl = APP_URL+"/vessel/"+$("#id").val();
                type = "PUT";     
            }else {
                ajaxUrl = APP_URL+"/vessel";
                type = "POST";
            }
            $.ajax({
                url: ajaxUrl,
                type: type,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status == 'success'){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            html :'<p>'+response.message+'</p>',
                            showConfirmButton: false,
                            timer: 1500
                        });                        
                        window.location.reload();
                    }else{
                        var msg='';
                        $.each(response.result, function (k,v)  {
                            if(msg == '')
                                msg = v;
                            else
                                msg = msg+', '+v;
                        });
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: msg,
                            showConfirmButton: false,
                            showCancelButton: true,
                            cancelButtonText: '<i class="fas fa-3x fa-check-circle tooltips text-success"></i>',
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    //toastr.error('Unable to Process Please Contact Support');
                }
            });
               
        }
    });

    $("#btnVesselsAdd").click(function () {
        $('.form-control').removeClass('is-invalid');
        //Reset the Bootstrap Form validator
        var validator = $( "#frmVessels" ).validate();
        validator.resetForm();
        $("#mdlVesselsTitle").text("Add Vessel");
        $("#name").val("");
        $("#description").val("");
        $("#loa").val("");
        $("#beam").val("");
        $("#draft").val("");
    });
   
    // Edit the Vessel row data
    $('#dtVessel').on('click', '.edit', function () {
        $('.form-control').removeClass('is-invalid');
        var table = $('#dtVessel').DataTable();
        var rowData = table.row($(this).closest('tr')).data();
        var name            = rowData[Object.keys(rowData)[0]];
        var description     = rowData[Object.keys(rowData)[1]];
        var loa             = rowData[Object.keys(rowData)[2]];
        var beam            = rowData[Object.keys(rowData)[3]];
        var draft           = rowData[Object.keys(rowData)[4]];
        var id              = rowData[Object.keys(rowData)[5]];
        var validator = $( "#frmVessels" ).validate();
        validator.resetForm();
        $("#mdlVesselsTitle").text("Edit Vessel");  
        $("#name").val(name);
        $("#description").val(description);
        $("#loa").val(loa);
        $("#beam").val(beam);
        $("#draft").val(draft);
        $("#id").val(id);
        $("#modal-vessels").modal("show");
    });

    //Delete the Vessel row data
    $('#dtVessel').on('click', '.delete', function () {
        var table = $('#dtVessel').DataTable();
        var rowData = table.row($(this).closest('tr')).data();
        var rowId = rowData[Object.keys(rowData)[5]];
        $("#id").val(rowId);
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: false,
            showConfirmButton: false,
            html :`<p>You want to delete this Vessel?</p></br>
            <span  class=" tooltips" data-placement="bottom"  title="Delete Vessel" onClick="return deleteVessel();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
            <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
        });
    });
});

function deleteVessel() {
    $.ajax({
        url: APP_URL+"/vessel/"+$("#id").val(),
        type: "delete",
        dataType: "json",
        success: function(response) {
            if(response.status == 'success') {
                Swal.fire("Deleted!", "Vessel has been deleted.", "success");
                window.location.reload();
            }
            else {
                var msg='';
                $.each(response.result, function (k,v)  {
                    if(msg == '')
                        msg = v;
                    else
                        msg = msg+', '+v;
                });
                Swal.fire("Error!", ""+msg+"", "error");
            }
        },
        error: function() {
            //toastr.error('Unable to Process Please Contact Support');
        }
    });
}