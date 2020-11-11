$(document).ready(function () {
    $("#orgNameSave").hide();
    $("#currencySave").hide();
    $("#organisationForm").validate({
        rules: {
            name: {
                required: true,
                maxlength: 60
            },
            mobile_no: {
                required: true,
                maxlength: 20,
                digits: true
            },
            address: {
                required: true
            },
            primary_contact: {
                required: true,
                maxlength: 40
            },
            primary_mobile_no: {
                required: true,
                maxlength: 20,
                digits: true
            },
            primary_email: {
                required: true,
                maxlength: 60
            },
            secondary_contact: {
                maxlength: 40
            },
            secondary_mobile_no: {
                maxlength: 20,
                digits: true
            },
            secondary_email: {
                maxlength: 60
            }
        },
        messages: {
            name: {
                required: "Please enter a Organization Name",
                maxlength: "Organization Name cannot exceed 60 characters."
            },
            mobile_no: {
                required: "Please enter Phone Number",
                maxlength: "Phone Number cannot exceed 15 characters."
            },
            address: {

                required: "Please enter an Address",
                number: "Please enter  Address"
            },
            primary_contact: {
                required: "Please enter primary contact name",
                number: "Name cannot exceed 40 characters"
            },
            primary_mobile_no: {
                required: "Please enter primary phone number",
                number: "Phone number cannot exceed 20 characters"
            },
            primary_email: {
                 required: "Please enter email",
                number: "Email cannot exceed 60 characters"
            },
            secondary_contact: {
                number: "Name cannot exceed 40 characters"
            },
            secondary_mobile_no: {
                number: "Phone number cannot exceed 20 characters"
            },
            secondary_email: {
                number: "Email cannot exceed 60 characters"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            //var formData = new FormData(document.getElementById("organisation"));
            $.ajax({
                type: 'PUT',
                url: APP_URL+"/organization/"+$('#id').val(),
                data: $(form).serialize(),
                async: false,
                dataType: 'Json',
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
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
        
    });
    $("#orgNameEdit").click(function () {
        $("#orgNameSave").show();
        $("#disableOrg").removeAttr("disabled");   
        $(this).hide();
    });

    $("#currency").validate({
        rules: {
            currency_id: {
                required: true
            },
            rate_per_trip: {
                required: true,
                number: true,
            }
        },
        messages: {
            currency_id: {
                required: "Please select Currency"
            },
            rate_per_trip: {
                required: "Please enter Rates per Trip",
                number: "Please enter a decimal value for Rates per Trip",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            $.ajax({
                type: 'PUT',
                url: APP_URL+"/organization/"+$('#id').val(),
                data: $(form).serialize(),
                async: false,
                dataType: 'Json',
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
                error: function(e) {
                    console.log(e);
                }
            });
        }
        
    });
    $("#currencyEdit").click(function () {
        $("#currencySave").show(); 
        $("#disableCurrency").removeAttr("disabled");
        $(this).hide();
    });
    $('#currency_id').on('change', function() {  
        var currency_id =  document.getElementById('currency_id').value;
        var currency_code =  document.getElementById('currency_code');
        if (currency_id ==''){
            currency_code.value ="";
        }
        else{
            currency_code.value = currency_id;
        }
        
        
    });
});