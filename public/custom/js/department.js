$(function() {
    //listing datatable for trucks
    $('#departments').DataTable({            
        "responsive": true,
        "order": [],
    });
    $('#add_department').validate({
        rules: {
          name: {
            required: true,
            maxlength: 50,
          },
          description: {
            maxlength: 150,
          },
        },
        messages: {
          name: {
            required: "Please enter department name",
            maxlength: "Department should not exceed 50 charaters."
          },
          description: {
            maxlength: "Description should not exceed 150 charaters."
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
        
         submitHandler: function(form) {
            var text = '';
            var URL = '';
            var type = '';
             if($("#hidden_id").val() != ""){
                  text = "Updated";
                  URL =  APP_URL+"/department/"+$("#hidden_id").val();
                  type = 'put';
             }else{
                  URL =  APP_URL+"/department";
                  text = "Saved";
                  type = 'post';
             }         
           $.ajax({
                type: type,
                url: URL,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status_code == 200){
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500});
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
                }            
            });
        }    
    });
    //Delete the Department row data
    $('#departments').on('click', '.delete', function () {
        
        var table = $('#departments').DataTable();
        var rowData = table.row($(this).closest('tr')).data();

        var rowId = rowData[Object.keys(rowData)[2]];
        $("#dept_id").val(rowId);
        Swal.fire({
            title: "Are you sure?",
            //text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: false,
            //confirmButtonColor: "#3085d6",
            showConfirmButton: false,
            html :`<p>You want to delete this Department?</p></br>
            <span  class=" tooltips" data-placement="bottom"  title="Delete Department" onClick="return deleteDepartment();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
            <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
        });
    });
});

$("#add_department_btn").click(function () {     
    $('.form-control').removeClass('is-invalid');
    $("#modal-default").modal("show");
    $("#add_department")[0].reset();
    $( "#add_department" ).validate();
    var validator = $( "#add_department" ).validate();       
    validator.resetForm();
    $('.modal-title').text("Add Department");     
      
});

function editDepartment(id)
{    $('.form-control').removeClass('is-invalid');
    $('.modal-title').text("Edit Department");
    $("#modal-default").modal("show");
    var validator = $( "#add_department" ).validate();       
    validator.resetForm();
    $.ajax({
        url: APP_URL+"/department/"+id,
        type: "get",
        dataType: "json",
        success: function(response) {
            if(response.status == 'success'){
                $("#name").val(response.result.name);
                $("#description").val(response.result.description);
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

 function deleteDepartment()
 {
   $.ajax({
        url: APP_URL+"/department/"+$("#dept_id").val(),
        type: "delete",
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
            Swal.fire('Unable to get data Contact Support');
        }
    });
}