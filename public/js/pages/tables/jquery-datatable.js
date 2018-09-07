$(function () {
    $('.js-basic-example').DataTable({
        responsive: true,
        "order": [[ 0, "desc" ]]
    });

    //Exportable table
    $('.js-exportable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        "order": [[ 0, "desc" ]],
        buttons: [
            'excel', 'pdf'
        ]
    });
});