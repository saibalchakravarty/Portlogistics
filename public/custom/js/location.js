$(document).ready(function () {
    //Location Datatable Rendering
    $("#dtLocation").DataTable({ 
        "responsive": true, 
        "order": [],
    });

    //Form validation

    $("#frmLocations").validate({
        rules: {
            location: {
                required: true,
                maxlength: 30
            },
            description: {
                maxlength: 150
            },
            type: {
                required: true
            }
        },
        messages: {
            location: {
                required: "Please enter a location name",
                maxlength: "Location should not exceed 30 characters.",
            },
            description: {
                maxlength: "Description should not exceed 150 characters."
            },
            type: {
                required: "Please select Type"
            }
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
            
         //  var formData = new FormData(document.getElementById("frmLocations"));
           var ajaxUrl = '';
           var type = '';
            if($("#hidden_id").val() != "")
            {
                type = "PUT"; 
                ajaxUrl = APP_URL+"/location/"+$("#hidden_id").val();  
            }
            else
            {
                type = "POST";
                ajaxUrl = APP_URL+"/location";
            }
            $.ajax({
                url: ajaxUrl,
                type: type,
                data: $(form).serialize(),
                success: function(response) {
                  
                    if(response.status == 'success')
                    {
                        Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: response.message,
                          showConfirmButton: false,
                          timer: 1500
                        })
                       window.location.reload();
                    }
                    else
                    {
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
                }
            });
               
        }
    });
    $("#btnLocationsAdd").click(function () {
        $('.form-control').removeClass('is-invalid');
        var validator = $( "#frmLocations" ).validate();
        validator.resetForm();
        $("#mdlLocationsTitle").text("Add Location");
        $("#location").val("");
        $("#description").val("");
        $("input[name=type]").prop('checked', false);
    });
    //Delete the Location row data
    $('#dtLocation').on('click', '.delete', function () {
        
        var table = $('#dtLocation').DataTable();
        var rowData = table.row($(this).closest('tr')).data();

        var rowId = rowData[Object.keys(rowData)[3]];
        $("#location_id").val(rowId);
        Swal.fire({
            title: "Are you sure?",
            //text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: false,
            //confirmButtonColor: "#3085d6",
            showConfirmButton: false,
            html :`<p>You want to delete this Location?</p></br>
            <span  class=" tooltips" data-placement="bottom"  title="Delete Location" onClick="return deleteLocation();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
            <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
        });
    });

});
function editLocation(id){
    $('.form-control').removeClass('is-invalid');
    $("#mdlLocationsTitle").text("Edit Location");
    $("#modal-locations").modal("show");
    var validator = $( "#frmLocations" ).validate();      
    validator.resetForm();
     $.ajax({
            url: APP_URL+"/location/"+id,
            type: "GET",
            dataType: "json",
            // data: {id:id},
            success: function(response) {
                 if(response.status == 'success'){
                     $("#location").val(response.result.location);
                     $("#description").val(response.result.description);
                     $("input[name=type][value="+response.result.type+"]").prop('checked', true);
                     $("#hidden_id").val(response.result.id);
                 }else{
                     var msg='';
                     $.each(response.result, function (k,v)  {
                      if(msg == '')
                         msg = v;
                      else
                         msg = msg+', '+v;
                     });
                     Swal.fire("Error!", "'"+msg+"'", "error");
                 }
            },
            error: function() {
                 Swal.fire('Unable to get data Contact Support');
            }
         });
    
    return false;
}

function deleteLocation(){
     $.ajax({
        url: APP_URL+"/location/"+$("#location_id").val(),
        type: "DELETE",
        //data: {id:$("#location_id").val()},
        dataType: "json",
        success: function(response) {
            if(response.status == 'success')
            {
                Swal.fire("Deleted!", response.message, "success");
                window.location.reload();
            }
            else
            {
                 var msg='';
              $.each(response.result, function (k,v)  {
               if(msg == '')
                  msg = v;
               else
                  msg = msg+', '+v;
              });
              Swal.fire("Error!", "'"+msg+"'", "error");
            }
        },
        error: function() {
            toastr.error('Unable to delete Contact Support');
        }
    });
}