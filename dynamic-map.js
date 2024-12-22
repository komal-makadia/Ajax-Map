jQuery(document).ready(function ($) {
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

    
});


