/* ====================================
   ADMIN APP CONFIGURATION
   Toastr & DataTables Setup
   ==================================== */

// ════════ TOASTR NOTIFICATION CONFIG ════════
$(document).ready(function() {
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showDuration": "300",
            "hideDuration": "300",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        // Show success message if session has one
        const successMsg = $('meta[name="success-message"]').attr('content');
        if (successMsg) {
            toastr.success(successMsg);
        }
    }

    // ════════ DATATABLE CONFIG ════════
    if ($.fn.DataTable) {
        const tables = $('.datatable, #all-table-common');
        tables.DataTable({
            responsive: true,
            paging: true,
            searching: true,
            ordering: true,
            lengthMenu: [5, 10, 25, 50, 100],
            pageLength: 10,
            language: {
                lengthMenu: "Show _MENU_ entries",
                search: "_INPUT_",
                searchPlaceholder: "Search records...",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                },
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries to show",
                emptyTable: "No data available"
            }
        });
    }
});
