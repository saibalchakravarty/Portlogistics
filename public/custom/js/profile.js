$(function () {
    /*Open Change Passowrd Modal with resetting previous values and validations*/
    $("#changePasswordBtn").click(function () {
        resetChangePasswordForm();
        $("#changePasswordModal").modal('show');
    });

    /*Click on edit icon*/
    $(".profile-name-edit").click(function () {
        resetNameForm();
        $(".default-view").hide();
        $(".edit-view").show();
    });
    /*Click on Upload Photo Button*/
    // Add the following code if you want the name of the file appear on select
    $(".custom-file-input").on("change", function() {
      var fileName = $(this).val().split("\\").pop();
      $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
   

    /*Image Upload*/
    $("#imgupload").change(function () {
        //uploadFile(file);
    });
    
    $(".close-alert").click(function(){
        $(this).closest('.alert').addClass('hide');
        $(this).closest('.alert').find('.message').html('');
    });

    /*Change Password Validation*/
    $('#changePasswordForm').validate({
        rules: {
            old_password: {
                required: true,
                remote: {
                    url: APP_URL + "/validateCurrentPassword",
                    type: "post"
                }
            },
            new_password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "#new_password",
            }
        },
        messages: {
            old_password: {
                required: "Please enter current password",
                remote: "Current password entered is incorrect"
            },
            new_password: {
                required: "Please enter a new password",
                minlength: "Password length should not be less than 8 characters",
            },
            confirm_password: {
                required: "Please confirm your password",
                equalTo: "New Password and Confirm Password must be same",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('div').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            hideFlashMessage();
            $.ajax({
                type: 'POST',
                url: APP_URL + "/updatePassword",
                data: $(form).serialize(),
                async: false,
                dataType: 'JSON',
                success: function (response) {
                    if(response.status == 'success') {
                        $("#changePasswordModal").modal('hide');
                        $("#profile-success").removeClass('hide');
                        $("#profile-success .message").html(response.message);
                    } else {
                        $("#changePasswordModal").modal('hide');
                        $("#profile-error").removeClass('hide');
                        var err = '';
                        if(typeof(response.result) == 'string') {
                            err = response.result;
                        } else if(typeof(response.result) == 'object') {
                            $.each(response.result, function (i,v) {
                                err += v[0]+'<br/>';
                            });
                        }
                        $("#profile-error .message").html(err);
                    }
                    resetChangePasswordForm();
                    setTimeout(function() {
                        hideFlashMessage();
                    }, 3000);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });

    /*Submit Name Form*/
    $('#changeNameForm').validate({
        rules: {
            first_name: {
                required: true,
                maxlength: 40
            },
            last_name: {
                required: true,
                maxlength: 40
            }
        },
        messages: {
            first_name: {
                required: "Please enter first name",
                maxlength: "First name cannot exceed 40 characters"
            },
            last_name: {
                required: "Please enter last name",
                maxlength: "Last name cannot exceed 40 characters"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('div').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },

        submitHandler: function (form) {
            hideFlashMessage();
            $.ajax({
                type: 'POST',
                url: APP_URL + "/updateName",
                data: $(form).serialize(),
                async: false,
                dataType: 'JSON',
                success: function (response) {
                    if(response.status == 'success') {
                        $(".edit-view").hide();
                        $(".default-view").show();
                        $("#profile_name").html(response.result.first_name+' '+response.result.last_name);
                        $("#first_name").val(response.result.first_name);
                        $("#last_name").val(response.result.last_name);
                        $("#first_name").attr('default',response.result.first_name);
                        $("#last_name").attr('default',response.result.last_name);
                        $("#profile-success").removeClass('hide');
                        $("#profile-success .message").html(response.message);
                    } else {
                        $(".edit-view").hide();
                        $(".default-view").show();
                        $("#first_name").val($("#first_name").attr('default'));
                        $("#last_name").val($("#last_name").attr('default'));
                        $("#profile-error").removeClass('hide');
                        var err = '';
                        if(typeof(response.result) == 'string') {
                            err = response.result;
                        } else if(typeof(response.result) == 'object') {
                            $.each(response.result, function (i,v) {
                                err += v[0]+'<br/>';
                            });
                        }
                        $("#profile-error .message").html(err);
                    }
                    resetNameForm();
                    setTimeout(function() {
                        hideFlashMessage();
                    }, 3000);
                },
                error: function (e) {
                    console.log(e);
                }
            });
        }
    });

    $('#btnProfileImgUpldSubmit').click(function() {
        var chkValidateStatus = validateFileUpload();
        if(chkValidateStatus) 
        {
           
            var formData = new FormData(document.getElementById('frmProfileUpload'));
           $.ajax({
                url:  APP_URL + "/user/image",
                type: "POST",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
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
                        Swal.fire("Error!", "'"+msg+"'", "error");
                    }
                },
                error: function() {
                    toastr.error('Unable to Process Please Contact Support');
                }
            });
        }
    });
});
function validateFileUpload() {

    var fuData = document.getElementById('profileImage');
    var FileUploadPath = fuData.value;

    if (FileUploadPath == '') {
        Swal.fire("Error!", "Please upload an image !", "error");
        $('#profileImage').val("");
        $('#lblProfileImage').val("Choose file");

    } else {
        var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();



        if (Extension == "png" || Extension == "jpg" || Extension == "jpeg") {


                if (fuData.files && fuData.files[0]) {

                    var size = fuData.files[0].size;
                   const fileSize = Math.round((size / 1024));
                    if(fileSize > 2096){
                         Swal.fire("Error!", "Please select a file less than 2mb !", "error");
                         $('#profileImage').val("");
                         $('#lblProfileImage').val("Choose file");
                        return;
                    }else{
                        /*var reader = new FileReader();

                        reader.onload = function(e) {
                            $('#blah').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(fuData.files[0]);*/
                        return true;
                    }
                }

        } 


    else {
            Swal.fire("Error!", "Photo only allows file types of PNG or JPG or JPEG", "error");
            $('#profileImage').val("");
            $('#lblProfileImage').val("Choose file");
        }
    }
}
function resetChangePasswordForm() {
    $("#changePasswordModal .form-control").val('');
    var validator = $("#changePasswordForm").validate();
    validator.resetForm();
    $("#changePasswordModal .form-control").removeClass('is-invalid');
}

function resetNameForm() {
    var validator = $("#changeNameForm").validate();
    validator.resetForm();
    $("#changeNameForm .form-control").removeClass('is-invalid');
}

function hideFlashMessage() {
    if(!$("#profile-success").hasClass('hide')) {
        $("#profile-success").addClass('hide');
    }
    if(!$("#profile-error").hasClass('hide')) {
        $("#profile-error").addClass('hide');
    }
}