$(function () {
    $(document).on('click', '#delCacheRole', function () {  
  delCacheRole();
});

function delCacheRole() {
   var url= APP_URL + "clear-cache-menu";
    $.ajax({
        type: 'post',
        url: url,
        data: {},
         dataType: "json",
        success: function(response) {


            if (response.status == 'success') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                window.location.reload();
            } else {
                var msg = '';
                $.each(response.result, function(k, v) {
                    if (msg == '') msg = v;
                    else msg = msg + ', ' + v;
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
}$(document).on('click', '#delCacheData', function () {  
  delCacheData();
});

function delCacheData() {
   var url= APP_URL + "clear-cache-data";
    $.ajax({
        type: 'post',
        url: url,
        data: {},
         dataType: "json",
        success: function(response) {
           
            if (response.status == 'success') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: response.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                window.location.reload();
            } else {
                var msg = '';
                $.each(response.result, function(k, v) {
                    if (msg == '') msg = v;
                    else msg = msg + ', ' + v;
                });
                Swal.fire("Error!", "'" + msg + "'", "error");
            }
        }
    });
}
});
