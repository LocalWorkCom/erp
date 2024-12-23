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
                    <button type="button" class="btn w-100 reversed main-color"
                        id="onMapBtn">@lang('header.onmap')</button>
                </div>
            </div>
        </div>
    </div>
</section>


@push('scripts')
    <script>
        < script >
            document.addEventListener('DOMContentLoaded', function() {
                // Handle "Access Location" button click
                document.getElementById('accessLocationBtn').addEventListener('click', function() {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            // Get the user's latitude and longitude
                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;

                            // Optionally, send these coordinates to the server or do something with them
                            console.log('Latitude: ' + latitude + ', Longitude: ' + longitude);

                            // Close the modal after accessing location
                            $('#modal').modal('hide'); // This requires jQuery and Bootstrap modal
                        }, function(error) {
                            alert('Geolocation access denied or failed.');
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
            });
    </script>

    </script>
@endpush
