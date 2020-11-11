$(function () {
    $('#from,#to').datetimepicker({
        format: 'DD/MM/YYYY HH:mm',
        ignoreReadonly: true
    });
    getPlanningList();
    $('#btopPlanningTbl tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open this row
            row.child(format(row.data())).show();
            tr.addClass('shown');
        }
    });
});
function getPlanningList() {
    $('#btopPlanningTbl').dataTable().fnDestroy();
    table = $('#btopPlanningTbl').DataTable({
        processing: true,
        serverSide: true,
        serverMethod: "POST",
        pageLength: 10,
        searching: true,
        lengthMenu: [[10, 20, 30, 40, -1], [10, 20, 30, 40, "All"]],
        columns: [
            {
                "className": 'details-control',
                "orderable": false,
                "data": null,
                "defaultContent": ''
            },
            {data: "vessel_name"},
            {data: "berth_name"},
            {data: "date_from"},
            {data: "date_to"},
            {data: "cargo_name"},
            {data: "created_at"},
            {data: "truck_list"},
            {data: "action"}
        ],
        ajax: {
            cache: false,
            url: APP_URL + '/plan/list-ajax',
            data: {
                "_token": token,
                filterParams: $("#filterForm").serialize()
            }
        }
    });
}

function format(row_data) {
    var content = '' +
            '<table cellpadding="5" cellspacing="0" border="0" style="width:30%; margin-left:1.5rem">' +
            '<tbody style="border: 1px solid #dee2e6;">' +
            '<tr><th class="child-table-header">Customer Name</th><th class="child-table-header">Plots</th></tr>';
    if(row_data.details.length > 0) {
        for (var i in row_data.details) {
            var consignee = row_data.details[i].consignee;
            var destinations = (row_data.details[i].destinations == null) ? 'NA' : row_data.details[i].destinations;
            content += '<tr><td>' + consignee + '</td><td>' + destinations + '</td></tr>';
        }
    } else {
        content += '<tr><td colspan="2" style="text-align:center">No Data Found</td></tr>';
    }
    content += '' +
            '</tbody>' +
            '</table>';
    return content;
}



$(document).on('click', '.delete-plan', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to delete this plan?",
        icon: 'warning',
        showCancelButton: true,
        
        cancelButtonText: '<i title="Cancel"  class="fas fa-3x fa-times-circle tooltips text-danger"></i>',
        confirmButtonText: '<i title="Delete Plan"class="fas fa-3x fa-check-circle tooltips text-success"></i>',
        
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'DELETE',
                url: APP_URL + "/plan/" +$(this).data('id'),
                async: false,
                dataType: 'JSON',
                success: function (response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        window.location.reload();
                    } else {
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
    });
})

function filterPlanning() {
    if(($("#date_from").val() != '') && ($("#date_to").val() != '')) {
        var from = $("#date_from").val();
        var to = $("#date_to").val();
        if((moment(to,'DD/MM/YYYY HH:mm').format("X")) < (moment(from,'DD/MM/YYYY HH:mm').format("X"))) {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: "To Time cannot be prior to the From Time",
                showConfirmButton: false,
                timer: 1500
            });
            return false;
        }
    }
    getPlanningList();
}

function resetFilter() {
    $("#filterForm .form-control").val('');
    $("#filterForm .select2").val('').trigger('change.select2');
    getPlanningList();
}