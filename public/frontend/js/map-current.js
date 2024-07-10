/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";
var mapLat = mapLat;
var mapLong = mapLong;
localStorage.setItem('lat', '');
localStorage.setItem('long', '');
localStorage.setItem('is-pickup', '');
localStorage.setItem('address', '');

function initAutocomplete() {
    if (mapLat != '' && mapLong != '') {
        getLocation(mapLat, mapLong);
    } else {
        getLocation(null, null);
    }
    var input = document.getElementById('autocomplete-input');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        $('#lat').val(place.geometry.location.lat());
        $('#long').val(place.geometry.location.lng());
        localStorage.setItem('lat', place.geometry.location.lat());
        localStorage.setItem('long', place.geometry.location.lng());
        postalCode(place.geometry.location.lat(), place.geometry.location.lng());
        if (!place.geometry) {
            return;
        }
    });

    if ($('.main-search-input-item')[0]) {
        setTimeout(function () {
            $(".pac-container").prependTo("#autocomplete-container");
        }, 300);
    }
}
var geocoder;

function getLocation(lat, long) {
    geocoder = new google.maps.Geocoder();
    if (navigator.geolocation) {
        if (lat && long) {
            showGetPosition(lat, long)
        } else {
            navigator.geolocation.getCurrentPosition(showPosition);
        }
    } else {
        var msg = "Geolocation is not supported by this browser.";
        alert(msg);
    }
}

function showPosition(position) {
    var Latitude = position.coords.latitude;
    var Longitude = position.coords.longitude;
    $('#lat').val(Latitude);
    $('#long').val(Longitude);

    var latlng = new google.maps.LatLng(Latitude, Longitude);
    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                $('#autocomplete-input').val(results[0].formatted_address);
            }
        }
    })

}

function showGetPosition(lat, long) {
    var Latitude = lat;
    var Longitude = long;
    $('#lat').val(Latitude);
    $('#long').val(Longitude);
    postalCode(lat, long);
    var latlng = new google.maps.LatLng(Latitude, Longitude);
    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[1]) {
                $('#autocomplete-input').val(results[0].formatted_address);
            }
        }
    })
}

function postalCode(lat, long) {

    var postalCode;
    var city;
    var street_name;
    var latlng = new google.maps.LatLng(lat, long);
    geocoder = new google.maps.Geocoder();

    geocoder.geocode({
        'latLng': latlng
    }, function (results, status) {
        //console.log(results);
        if (status === google.maps.GeocoderStatus.OK) {
            // console.log("======= Results =======", results);
            for (var i = 0; i < results.length; i++) {
                for (var j = 0; j < results[i].address_components.length; j++) {
                    for (var k = 0; k < results[i].address_components[j].types.length; k++) {
                        if (results[i].address_components[j].types[k] == "postal_code" && results[i].address_components[j].types[k+1] != "postal_code_prefix") {
                            postalCode = results[i].address_components[j].short_name;
                        }
                        if (results[i].address_components[j].types[k] == "locality") {
                            city= results[i].address_components[j].short_name;
                        }
                        if (results[i].address_components[j].types[k] == "route") {
                            street_name= results[i].address_components[j].long_name;
                        }
                    }
                }
            }

            // $('#street_name').val(street_name);
            // $('#postal_code').val(postalCode);
            // $('#city_name').val(city);

            let address = {
                street: street_name,
                city: city,
                postalCode: postalCode
            }

            localStorage.setItem('address', JSON.stringify(address));
        } else {
            alert("Geocoder failed due to: " + status);
        }
    });
}

