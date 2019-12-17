;(function ($, window) {
    "use strict";

    //Date range search
    $('#daterange-btn').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('.search-project input[name="date_filter"]').on('apply.daterangepicker', function(ev, picker) {
        ev.stopPropagation();
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
    });
    $('.search-project input[name="date_filter"]').on('cancel.daterangepicker', function(ev, picker) {
        ev.stopPropagation();
        $(this).val('');
    });

    //Active search by user
    $('input[type="checkbox"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue'
    });

    //Initialize Select2 search tag
    $('.search-project .filter-tags-techno').select2();

    //Clear input filter
    var $filterTags = $(".search-project .filter-tags-techno");
    $(".search-project .filter-clear").on("click", function () {
        $filterTags.val(null).trigger("change");
        $('.search-project .icheckbox_minimal-blue').removeClass('checked').attr('aria-checked', 'false');
        $('.search-project .icheckbox_minimal-blue input').prop('checked', false );
        $('.search-project input[name="search"], .search-project input[name="date_filter"]').val('');
    });
})(jQuery, window);