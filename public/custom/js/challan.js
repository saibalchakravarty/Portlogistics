$(function () {
    
    getChallanList();
    $('#currentdatediv').datetimepicker({
        format: 'YYYY-MM-DD',
        ignoreReadonly: true
    });
    $("#filterBtn").click(function () {
        getChallanList();
        if($("#created_at").val() != '' || $("#shift_id").val() != '' || $("#challan_no").val() != '') {
            $("#clearBtn").removeClass('hide');
        } else {
            $("#clearBtn").addClass('hide');
        }
        toggleFilterArea();
    });
    $("#clearBtn").click(function(){
        $(".filterable-txt").val('');
        $('.filterable-drp').val('').trigger('change.select2');
        var current_date = moment().format("YYYY-MM-DD");
        $('#created_at').val(current_date);
        $(".reconcile-status-btn:first").trigger('click');
        $("#clearBtn").addClass('hide');
        getChallanList();
        toggleFilterArea();
    });
    $(".reconcile-status-btn").click(function(){
        $(".challan-info-box").removeClass('active');
        $(this).find('.challan-info-box').addClass('active');
        $("#challan_is_deposit").val($(this).data('default'));
        $("#clearBtn").removeClass('hide');
        getChallanList();
    });
});
function getChallanList() {
    $("#challanTbl").dataTable().fnDestroy();
    $('#challanTbl').DataTable({
        "responsive": true,
        "processing": true,
        "serverSide": true,
        "serverMethod": "POST",
        "pageLength": 10,
        "searching": true,
        "lengthMenu": [[10, 20, 30, 40, -1], [10, 20, 30, 40, "All"]],
        "order": [],
        "columns": [
            {data: "id"},
            {data: "challan_no"},
            {data: "type"},
            {data: "truck_no"},
            {data: "origin"},
            {data: "cargo_name"},
            {data: "date_from"},
            {data: "date_to"},
            {data: "shift_name"},
            {data: "status"}
        ],
        "ajax": {
            cache: false,
            url: APP_URL + '/challan/list-ajax',
            data: {
                "_token": token,
                filterParams: $("#filterChallanForm").serialize()
            },
            "dataSrc": function(res){
                if(Object.keys(res.challanCounts).length) {
                    $("#total_challan_cnt").text(res.challanCounts.totalChallanCount);
                    $("#reconcile_challan_cnt").text(res.challanCounts.reconciledCount);
                    $("#not_reconcile_challan_cnt").text(res.challanCounts.notReconciledCount);
                } else {
                    $("#total_challan_cnt").text('0');
                    $("#reconcile_challan_cnt").text('0');
                    $("#not_reconcile_challan_cnt").text('0');
                }
                return res.data;
            }
        }
    });
}

$(document).on('click', '.challan_id', function () {
    if ($(this).prop("checked") == true) {
        $(this).closest('tr').addClass('selected');
    } else if ($(this).prop("checked") == false) {
        $(this).closest('tr').removeClass('selected');
    }
});
function toggleFilterArea(){
    $('.filterBox').slideToggle('slow');
}
$('.filterBtn').click(function () {
   toggleFilterArea();
});
function reconcileSelectedChallans() {
    var challan_ids = [];
    $('.challan_id:checked').each(function () {
        if($(this).data('reconcile-status') == '0') {
            challan_ids.push(this.value);
        }
    });
    if (challan_ids.length) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to deposit the challan(s)?",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: '<i title="Cancel"  class="fas fa-3x fa-times-circle tooltips text-danger"></i>',
            confirmButtonText: '<i title="Delete Plan"class="fas fa-3x fa-check-circle tooltips text-success"></i>',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    url: APP_URL + "/challan/reconcile",
                    data: {challan_ids: challan_ids},
                    async: false,
                    dataType: 'JSON',
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
                            window.location.reload();
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
            }
        })
    } else {
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: 'Please select the challan(s) you want to reconcile',
            showConfirmButton: false,
            timer: 1500
        });
    }
}