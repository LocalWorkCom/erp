<section class="location-pop-up">
    <div id="modal_access" class="modal fade" tabindex="-1">
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
            const hasLatitudeCookie = document.cookie.split('; ').some(row => row.startsWith('latitude='));

            if (!hasLatitudeCookie) {
                const modalElement = document.getElementById('modal_access');
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }

            document.getElementById('accessLocationBtn').addEventListener('click', function() {
                $('#modal_access').modal('hide');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        const currentLatitude = getCookie('latitude');
                        const currentLongitude = getCookie('longitude');

                        // Check if cookies need updating
                        if (currentLatitude !== latitude.toString() || currentLongitude !==
                            longitude.toString()) {
                            setCookie('latitude', latitude, 7);
                            setCookie('longitude', longitude, 7);
                            console.log('Cookies updated: Latitude=' + latitude + ', Longitude=' +
                                longitude);

                            // Refresh the page to load nearest branch data
                            location.reload();
                        } else {
                            console.log(
                            'Cookies already have the correct values. Refreshing page.');
                            location.reload();
                        }
                    }, function(error) {
                        console.error('Geolocation error:', error);

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


            function setCookie(name, value, days) {
                document.cookie = name + "=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
                var expires = "";
                if (days) {
                    var date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                document.cookie = name + "=" + (value || "") + expires + "; path=/";
            }

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
        });
    </script>
@endpush
