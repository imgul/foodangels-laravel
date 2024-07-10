/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$(document).ready(function () {
    load_data();

  

  

    function load_data() {
        var table = $('#maintable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#maintable').attr('data-url'),
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'label', name: 'label'},
                {data: 'rate', name: 'rate'},
                {data: 'status', name: 'status'},
                {data: 'action', name: 'action'},
            ],
            "ordering": false
        });

        // let hidecolumn = $('#maintable').data('hidecolumn');
        // if (!hidecolumn) {
        //     table.column(4).visible(false);
        // }
    }

    $('#maintable').on('draw.dt', function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
});
