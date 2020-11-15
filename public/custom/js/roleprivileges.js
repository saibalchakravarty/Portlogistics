$(document).ready(function(){
	//Initialize Select2 Elements
    $('.select2').select2()
    $('input').on('ifChecked', function (event) {
        $(this).closest("input").attr('checked', true);
    });
    // Role ADD Handler
    $('#btnRoleAdd').click(function(){
    	$("#mdlRoleTitle").text("Add Role");
    	$('#name').val("");
        $('#modal-role').modal('show');
        var validator = $( "#frmRole" ).validate();
		validator.resetForm();
    });
    $('#btnRoleEdit').click(function(){
    	var selectedRole = $("#cmbRole option:selected").text();
        var selectedRoleId = $("#cmbRole option:selected").val();
    	if($('#cmbRole').val() != '')
    	{
            $("#mdlRoleTitle").text("Edit Role");
            $('#name').val(selectedRole);
    		$('#id').val(selectedRoleId);
        	$('#modal-role').modal('show');

        	var validator = $( "#frmRole" ).validate();
			validator.resetForm();
    	}
    	else
    	{
            Swal.fire({
                title: false,
                //text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: false,
                //confirmButtonColor: "#3085d6",
                showConfirmButton: false,
                html :`<p>Please select a Role to update</p></br>
               
                <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
            });
    	}	
    });
    $('#btnRoleDelete').click(function(){
    	if($('#cmbRole').val() != '')
    	{
    		Swal.fire({
            title: "Are you sure?",
            //text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: false,
            //confirmButtonColor: "#3085d6",
            showConfirmButton: false,
            html :`<p>You want to delete this Role?</p></br>
            <span  class=" tooltips" data-placement="bottom"  title="Delete Role" onClick="return removeRole();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
            <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
        });
    	}
    	else
    	{
            Swal.fire({
                title: false,
                //text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: false,
                //confirmButtonColor: "#3085d6",
                showConfirmButton: false,
                html :`<p>Please select a Role to delete !</p></br>
               
                <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
            });
    	}	
    });
    $('input').on('change', function() {
	    if ($("#frmRole").valid()) {
	        $('#btnRoleSubmit').prop('disabled', false);  
	    } else {
	        $('#btnRoleSubmit').prop('disabled', 'disabled');
	    }
	});
    //Form validation
    
    $.validator.addMethod('regex', function(value, element, param) {
        return this.optional(element) ||
            value.match(typeof param == 'string' ? new RegExp(param) : param);
    },
    'Please enter a value in the correct format.');
    $("#frmRole").validate({    	
        rules: {
            name: {
                required: true,
                regex:'^[a-zA-Z0-9 ]+(([_][a-zA-Z0-9])?[a-zA-Z0-9]*)*$',
                maxlength: 50,
            }
        },
        messages: {
            name: {
                required: "Please enter Role.",
                regex: "Role format is not valid",
                maxlength: "Role should not exceed 50 characters.",
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
        unhighlight: function (element, errorClass, validClass,error) {
            $(element).removeClass("is-invalid");
            $(element).addClass("is-valid");
        },

    	submitHandler: function(form) { 
    		var apiUrl='';
    		var method = '';
            if($("#id").val() != "")
            {
                apiUrl = APP_URL+"/role/"+$("#id").val();
                method = 'put';
            }
            else
            {
                apiUrl = APP_URL+"/role";
                method = 'post';
            }
            $.ajax({
                url: apiUrl,
                type: method,
                data: $(form).serialize(),
                success: function(response) {
                    if(response.status == 'success'){
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
                        Swal.fire("Error!", "'"+msg+"'", "error");
                    }
                },
                error: function() {
                    toastr.error('Unable to Process Please Contact Support');
                }
            });
            
        }

    });
    // Event for saving Privileges wrt screens selected
    $('#btnSubmitPrivilege').click(function(){
        var chkedPrivilege = [];
        $(".chkPrivilege:checked").each(function() {
            chkedPrivilege.push($(this).val()); 
        });
        if($('#cmbRole').val() == '')
        {
            Swal.fire("Error!", "Please select a Role to save Privileges !", "error");
        }
        else if( parseInt(chkedPrivilege.length) == 0)
        {
           // Swal.fire("Error!", "Please check atleast one Privilege !", "error");
            Swal.fire({
                title: "Please check atleast one Privilege !",
                //text: "You won't be able to revert this!",
                icon: "error",
                showCancelButton: false,
                //confirmButtonColor: "#3085d6",
                showConfirmButton: false,
                html :`<p>Please check atleast one Privilege</p></br>
                <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`
            });
        }
        else
        { 
            Swal.fire({
                title: "Are you sure?",
                //text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: false,
                //confirmButtonColor: "#3085d6",
                showConfirmButton: false,
                html :`<p>You want to change the access for `+$('#cmbRole option:selected').text()+`?</p></br>
                <span  class=" tooltips" data-placement="bottom"  title="Save Privileges" onClick="return savePrivilges();" style="cursor:pointer;"><i class="fas fa-3x fa-check-circle tooltips text-success"></i></span>
                <span  class=" tooltips" data-placement="bottom" title="Cancel" onClick="swal.close();" style="cursor:pointer;"><i class="fas fa-3x fa-times-circle tooltips text-danger"></i></span>`,
            });
        }
    });

    // By Change Event Getting Privileges and setting as checked in Privilege checkbox
    $('#cmbRole').change(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url :APP_URL+"/role-privileges/getPrivileges",
            type: "post",
            data : {id : $('#cmbRole').val()},
            success:function(response)
            {
                if( (response.result).length > 0 )
                {
                    $.each(response.result, function (k,v)  {
                        $('#chk'+v.access_id).attr("checked","checked");
                    });
                }
                else
                {
                    $('.chkPrivilege').removeAttr("checked",false);
                }
            }
        });
    });
});
function removeRole()
{
    $.ajax({
        url: APP_URL+"/role/"+$('#cmbRole').val(),
        type: "delete",
        dataType: "json",
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

function changeAccess(chkedPrivilege)
{
    $('#btnSubmitPrivilege').html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    $.ajax({
        url :APP_URL+"/role-privileges/save",
        type: "post",
        data: {privileges : chkedPrivilege, roleId : $('#cmbRole').val()},
        success:function(response)
        {
            if(response.status == 'success'){
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
                Swal.fire("Error!", "'"+msg+"'", "error");
            }
        },
        error:function()
        {

        }
    });
}
function savePrivilges()
{
    var chkedPrivilege = [];
    $(".chkPrivilege:checked").each(function() {
        chkedPrivilege.push($(this).val()); 
    });
    $('#btnSubmitPrivilege').html('<i class="fas fa-spinner fa-spin"></i> Saving...');
    $.ajax({
        url :APP_URL+"/role-privileges/save",
        type: "post",
        data: {privileges : chkedPrivilege, roleId : $('#cmbRole').val()},
        success:function(response)
        {
            if(response.status == 'success'){
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
                Swal.fire("Error!", "'"+msg+"'", "error");
            }
        },
        error:function()
        {

        }
    });
}