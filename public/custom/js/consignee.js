$(function () {
    $('#list-consignee').DataTable({
        "responsive": true,
        "order": [],
    });

    $('#add_consignee').validate({
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
                required: "Please enter Consignee",
                maxlength: "Consignee should not exceed 50 charaters."
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
        submitHandler: function (form) {
            var URL = '';
            var type = '';
            if ($("#hidden_id").val() != "") {
                URL = APP_URL + "/consignee/"+$("#hidden_id").val();
                type = "PUT";
            } else {
                URL = APP_URL + "/consignee";
                type = "post";
            }
            $.ajax({
                type: type,
                url: URL,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        window.location.reload();
                    } else{
                        var msg='';
                        $.each(response.result, function (k,v) {
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
                            }
                        );
                    }
                }
            });
        }
    });
    //Delete the Consignee row data
    $('#list-consignee').on('click', '.delete', function () {
        var table = $('#list-consignee').DataTable();
        var rowData = table.row($(this).closest('tr')).data();
        var rowId = rowData[Object.keys(rowData)[2]];
        $("#consignee_id").val(rowId);
        Swal.fire({
            title: "Are you sure?",
            icon: "warning",
            showCancelButton: false,
            showConfirmButton: false,
            html :`<p>You want to delete this Consignee?</p></br>
            <span  class=" tooltips" data-placement="bottom"  title="Delete Consignee" onClick="return deleteConsignee();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
            <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
        });
    });
});

$("#add_consignee_btn").click(function () {
    $('.form-control').removeClass('is-invalid');
    $("#modal-default").modal("show");
    $("#add_consignee")[0].reset();
    $("#add_consignee").validate();
    var validator = $("#add_consignee").validate();
    validator.resetForm();
    $('.modal-title').text("Add Consignee");
});

function editConsignee(id) {
    $('.form-control').removeClass('is-invalid');
    $('.modal-title').text("Edit Consignee");
    $("#modal-default").modal("show");
    var validator = $("#add_consignee").validate();
    validator.resetForm();
    $.ajax({
        url: APP_URL + "/consignee/"+id,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if(response.status == 'success'){
                $("#name").val(response.result.name);
                $("#description").val(response.result.description);
                $("#hidden_id").val(response.result.id);
            } else {
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
        error: function () {
            //toastr.error('Unable to edit Consignee');
        }
    });

    return false;
}

function deleteConsignee() {
    $.ajax({
        url: APP_URL + "/consignee/"+$("#consignee_id").val(),
        type: "DELETE",
        dataType: "json",
        success: function (response) {
            if(response.status == 'success') {
                Swal.fire("Deleted!", "Consignee deleted successfully.", "success");
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
                Swal.fire("Error!", "'"+msg+"'", "error");
            }
        },
        error: function () {
            //toastr.error('Unable to delete Consignee');
        }
    });
}



