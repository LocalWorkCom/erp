<section class="location-pop-up">
    <div id="modal" class="modal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <h2>@lang('header.locationaccess')</h2>
                </div>
                <div class="modal-footer d-flex flex-column border-0">
                    <button type="button" class="btn w-100" id="accessLocationBtn">@lang('header.access')</button>
                    <button type="button" class="btn w-100 reversed main-color" data-bs-toggle="modal"
                        data-bs-target="#deliveryModal">@lang('header.onmap')</button>

                </div>
            </div>
        </div>
    </div>
</section>



@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY&callback=initMap" async defer>
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle "Access Location" button click
            document.getElementById('accessLocationBtn').addEventListener('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        // Get the user's latitude and longitude
                        var latitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        // Save latitude and longitude in cookies
                        setCookie('latitude', latitude,
                        7); // 7 is the number of days the cookie will last
                        setCookie('longitude', longitude, 7);

                        // Optionally, you can log or do something with the coordinates
                        console.log('Latitude: ' + latitude + ', Longitude: ' + longitude);

                        // Close the modal after accessing location
                        $('#modal').modal('hide'); // This requires jQuery and Bootstrap modal
                    }, function(error) {
                        // Log the error code and message for debugging
                        console.error('Geolocation error:', error);

                        // Provide user-friendly error message
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                alert(
                                    'You have denied the location request. Please enable location permissions.');
                                break;
                            case error.POSITION_UNAVAILABLE:
                                alert('Location information is unavailable.');
                                break;
                            case error.TIMEOUT:
                                alert('The request to get your location timed out.');
                                break;
                            default:
                                alert('An unknown error occurred while accessing your location.');
                                break;
                        }
                    });
                } else {
                    alert('Geolocation is not supported by this browser.');
                }
            });

            // Handle "On Map" button click (this will open a map)
            document.getElementById('onMapBtn').addEventListener('click', function() {
                // You can open a map in a new window or a modal. Here, I use a new window with Google Maps.
                var mapUrl = 'https://www.google.com/maps?q=0,0&z=2'; // Default zoom to world view
                window.open(mapUrl, '_blank'); // Open map in a new tab

                // Close the modal after opening the map
                $('#modal').modal('hide'); // This requires jQuery and Bootstrap modal
            });

            // Function to use the coordinates from cookies in another function
            function useLocationFromCookies() {
                var latitude = getCookie('latitude');
                var longitude = getCookie('longitude');

                if (latitude && longitude) {
                    console.log('Using stored location: Latitude = ' + latitude + ', Longitude = ' + longitude);

                    // You can now use these coordinates in your function
                    // For example, you can send them to the server or display them on a map

                    // Example: Send to server via AJAX
                    $.ajax({
                        url: '/your-server-endpoint',
                        method: 'POST',
                        data: {
                            latitude: latitude,
                            longitude: longitude,
                            _token: $('meta[name="csrf-token"]').attr(
                                'content') // Include CSRF token for Laravel
                        },
                        success: function(response) {
                            console.log('Location saved:', response);
                        },
                        error: function(error) {
                            console.log('Error:', error);
                        }
                    });
                } else {
                    console.log('No location available in cookies.');
                }
            }

            // Example usage of the useLocationFromCookies function
            useLocationFromCookies();
        });

        // Function to set a cookie
        function setCookie(name, value, days) {
            var expires = "";
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        // Function to get a cookie by name
        function getCookie(name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) === ' ') c = c.substring(1, c.length);
                if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
            }
            return null;
        }
    </script>
@endpush
