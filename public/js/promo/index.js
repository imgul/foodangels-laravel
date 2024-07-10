/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

load_data();

$('#date-search').on('click', function () {
    let startDate = $('#start_date').val();
    let endDate = $('#end_date').val();
    $('#maintable').DataTable().destroy();
    load_data(startDate, endDate);
});

$('#refresh').on('click', function () {
    $('#discount_type').val('');
    $('#maintable').DataTable().destroy();
    load_data();
});

function load_data(startDate = '', endDate = '') {
    var table = $('#maintable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: $('#maintable').attr('data-url'),
            data: {startDate : startDate, endDate : endDate}
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'from_date', name: 'from_date' },
            { data: 'to_date', name: 'to_date' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
        ],
        "ordering": false
    });

    let hidecolumn = $('#maintable').data('hidecolumn');
    if (!hidecolumn) {
        table.column(5).visible(false);
    }
}

$('.input-daterange').datepicker({
    todayBtn : 'linked',
    format : 'dd-mm-yyyy',
    autoclose : true
  });

$('#maintable').on('draw.dt', function () {
    $('[data-toggle="tooltip"]').tooltip();
})

function printDiv(divID) {
    "use strict";
    let oldPage = document.body.innerHTML;
    let divElements = document.getElementById(divID).innerHTML;
    document.body.innerHTML = "<html><head><title></title></head><body>" + divElements + "</body>";

    window.print();
    document.body.innerHTML = oldPage;
    window.location.reload();
}
