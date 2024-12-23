jQuery(document).ready(function ($) {

//Using Address
    $('#address').on('input', function (e) {
        e.preventDefault();

        const address = $('#address').val();

        if (!address) {
            alert('Please enter a valid address.');
            return;
        }

        $.ajax({
            url: ajax_map_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_google_map_by_address',
                address: address,
            },
            success: function (response) {
                //alert(response);
                $('#map-container').html(response);
            },
            error: function () {
                alert('Error loading map.');
            },
        });
    });

// USING API
    $('#load-map-api').on('click', function (e) {
        e.preventDefault();

        var addressAPI = $('#address-api').val();

        if (!addressAPI) {
            alert('Please enter a valid address.');
            return;
        }

        $.ajax({
            url: ajax_map_params.ajax_url,
            type: 'POST',
            data: {
                action: 'load_google_map_by_api',
                addressAPI: addressAPI,
            },
            success: function (response) {
                console.log(response.data);
                if (response.success) {
                    var latitude = response.data.latitude;
                    var longitude = response.data.longitude;
                    var formatted_address = response.data.formatted_address;

                    // Initialize the map
                    var map = new google.maps.Map(document.getElementById('map-container-api'), {
                        center: { lat: latitude, lng: longitude },
                        zoom: 12,
                    });

                    // Add a marker
                    new google.maps.Marker({
                        position: { lat: latitude, lng: longitude },
                        map: map,
                        title: formatted_address,
                    });
                } else {
                    alert(response.data || 'Failed to load map.');
                }
            },
            error: function () {
                alert('Error loading map.');
            },
        });
    });


//AUTO COMPLETE INPUT
$('#load-map-api').on('click', function (e) {
        e.preventDefault();
    
        var addressAPI = $('#address-api').val();
    
        if (!addressAPI) {
            alert('Please enter a valid address.');
            return;
        }
    
        var place = new google.maps.places.Autocomplete($('#address-api')[0]).getPlace();
    
        if (place && place.geometry) {
            var latitude = place.geometry.location.lat();
            var longitude = place.geometry.location.lng();
            var formatted_address = place.formatted_address;
    
            // Initialize the map
            var map = new google.maps.Map(document.getElementById('map-container-api'), {
                center: { lat: latitude, lng: longitude },
                zoom: 12,
            });
    
            // Add a marker
            new google.maps.Marker({
                position: { lat: latitude, lng: longitude },
                map: map,
                title: formatted_address,
            });
        } else {
            alert('Invalid address or no results found.');
        }
    });
    

    
});


document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('address-api');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.addListener('place_changed', function () {
        var place = autocomplete.getPlace();
        if (place.geometry) {
            var location = place.geometry.location;
            console.log('Selected Place:', {
                latitude: location.lat(),
                longitude: location.lng(),
                address: place.formatted_address,
            });
        } else {
            console.error('Place details are unavailable.');
        }
    });
});
