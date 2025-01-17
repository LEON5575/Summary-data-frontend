<!-- <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/jquery.dataTables.min.css"> -->
<script>
$(document).ready(function() {
    // Function to initialize DataTable
    function initializeDataTable() {
        $("#myTable").DataTable({
            "paging": false,
            "pageLength": 8
        });
    }

    // Check if DataTable is already initialized
    if ($.fn.DataTable.isDataTable('#myTable')) {
        // If it is, destroy it
        $('#myTable').DataTable().destroy();
    }

    // Initialize DataTable for the first time
    initializeDataTable();

    // Handle form submission
    $('#import_excel_from').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "<?php echo base_url(); ?>/import",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#import').attr('disabled', true);
                $('#import').val('Importing............');
            },
            success: function(data) {
                $('#message').html(data);
                $('#import_excel_from')[0].reset(); // Ensure the form ID is correct
                $('#import').attr('disabled', false);
                $('#import').val('Import');

                // Reinitialize DataTable after new data is loaded
                if ($.fn.DataTable.isDataTable('#myTable')) {
                    $('#myTable').DataTable().destroy();
                }
                initializeDataTable(); // Call the function to reinitialize
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Handle errors here
                $('#message').html('<div class="alert alert-danger">Error: ' + errorThrown + '</div>');
                $('#import').attr('disabled', false);
                $('#import').val('Import');
            }
        });
    });
});
</script>
</body>
</html>