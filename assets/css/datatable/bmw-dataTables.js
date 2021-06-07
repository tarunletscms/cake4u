var $=jQuery.noConflict();
$(document).ready(function() {

    $('.lets-datatable').DataTable({
        	"searching": false,
            "lengthChange": false,
             "pageLength": 35,
            "responsive":true
    });
});
