$(function () {
    $("#addUserForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 60
            },
            first_name: {
                required: true,
                maxlength: 40
            },
            last_name: {
                required: true,
                maxlength: 40
            },
            address1: {
                maxlength: 60
            },
            address2: {
                maxlength: 60
            },
            mobile_no: {
                required: true,
                number: true,
                maxlength: 20
            },
            country_id: {
                required: true
            },
            state_id: {
                required: true
            },
            city_id: {
                required: true
            },
            pin_code: {
                required: true,
                maxlength: 10,
                number: true
            },
            department_id: {
                required: true
            },
            role_id: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please enter an email address.",
                email: "Please enter a valid email",
                maxlength: "Email cannot exceed 60 characters."
            },
            first_name: {
                required: "Please enter First Name",
                maxlength: "First name cannot exceed 40 characters."
            },
            last_name: {
                required: "Please enter last name",
                maxlength: "Last name cannot exceed 40 characters."
            },
            mobile_no: {
                required: "Please enter phone number",
                number: "Please enter a valid phone number",
                maxlength: "Phone number length cannot exceed 20 characters."
            },
            address1: {
                maxlength: "Address Line 1 length cannot exceed 60 characters."
            },
            address2: {
                maxlength: "Address Line 2 length cannot exceed 60 characters."
            },
            country_id: {
                required: "Please select country"
            },
            state_id: {
                required: "Please select state"
            },
            city_id: {
                required: "Please select city"
            },
            pin_code: {
                required: "Please enter pincode",
                maxlength: "Pincode length cannot exceed 10",
                number: "Please enter a valid pincode"
            },
            department_id: {
                required: "Please select department"
            },
            role_id: {
                required: "Please select role"
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
            $("#sectionLoader").show();
            setTimeout(function () {
                $.ajax({
                    type: ($("#id").val() == '') ? 'POST' : 'PUT',
                    url: ($("#id").val() == '') ? APP_URL + '/user' : APP_URL + '/user/'+$("#id").val(),
                    data: $(form).serialize(),
                    async: false,
                    dataType: 'Json',
                    success: function (response) {
                        if (response.status == 'success') {
                            $("#sectionLoader").hide();
                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            window.location = APP_URL + '/users';
                        } else {
                            $("#sectionLoader").hide();
                            var err = '';
                            if (typeof (response.result) == 'string') {
                                err = response.result;
                            } else if (typeof (response.result) == 'object') {
                                $.each(response.result, function (i, v) {
                                    err += v[0] + '<br/>';
                                });
                            }
                            Swal.fire({
                                position: 'center',
                                icon: 'error',
                                title: err,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                    error: function (e) {
                        console.log(e);
                    }
                });
            }, 2000);
        }
    })
});