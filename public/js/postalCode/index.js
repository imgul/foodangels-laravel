/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
$(document).ready(function () {
    let postalCode = $('#postalCode').val();
    let restaurantId = $('#maintable').data('resturant_id');
    load_data(postalCode, restaurantId);

    function load_data(postalCode = '', restaurantId = 0) {
        var table = $('#maintable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: $('#maintable').attr('data-url'),
                data: {
                    postalCode: postalCode,
                    restaurantId: restaurantId // Pass restaurantId in the request
                }
            },
            columns: [
                {data: 'id', name: 'id'},
                {data: 'postal_code', name: 'postal_code'},
                {data: 'delivery_charge', name: 'delivery_charge'},
                {data: 'delivery_time', name: 'delivery_time'},
                {data: 'min_order', name: 'min_order'},
                {data: 'max_order', name: 'max_order'},
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
