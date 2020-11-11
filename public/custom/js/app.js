$(document).ready(function () {
    $("#sectionLoader").hide();
});
$(function () {

    $('.tooltips').tooltip();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(".number").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            return false;
        }
    });
    $('.select2').select2();
    //Remove extra whitespace
    $('input[type=text], textarea').blur(function () {
        var el = $(this);
        el.val(el.val().replace(/(^\s*)|(\s*$)/gi, "").replace(/[ ]{2,}/gi, " ").replace(/\n +/, "\n"));
        return;
    });
    $('.datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    });
    //Compare From and To Date
    $.validator.addMethod("greaterThan", function (value, element, params) {
        var to_date = moment(value, 'DD/MM/YYYY HH:mm');
        var from_date = moment($(params).val(), 'DD/MM/YYYY HH:mm');
        if (to_date.isValid() && from_date.isValid()) {
            var date_to = to_date.format("X");
            var date_from = from_date.format("X");
            return date_to > date_from;
        }
        return true;
    }, 'Must be greater than from date.');
    //Date Should Be Greater Than Now
    $.validator.addMethod("greaterThanNow", function (value, element, params) {
        var selected = moment(value, 'DD/MM/YYYY HH:mm');
        var now = moment($(params).val(), 'DD/MM/YYYY HH:mm');
        if (selected.isValid() && now.isValid()) {
            var selected_datetime = selected.format("X");
            var current_detatime = now.format("X");
            return selected_datetime > current_detatime;
        }
        return true;
    }, 'Selected time cannot be prior to the current time');
    $(".filter-btn").click(function () {
        $(".filter-area").toggle('slow');
    });
});
$(document).on('keypress', 'input[type=search]', function (e) {
    var k = e.keyCode,
        $return = ((k > 64 && k < 91) || (k > 96 && k < 123) || k == 8 || k == 32 || k == 45 || (k >= 48 && k <= 57));
    if (!$return) {
        return false;
    }
});
$(document).on('cut copy paste', 'input[type=search]', function (e) {
    e.preventDefault();
});