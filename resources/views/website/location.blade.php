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
                    {{-- <button type="button" class="btn w-100 reversed main-color" data-bs-toggle="modal"
                        data-bs-target="#deliveryModal">@lang('header.onmap')</button> --}}
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
    <script>
        var routeMenuUrl = "{{ route('menu', ['branch_id' => '__BRANCH_ID__']) }}"; // Temporary URL
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let originalBranches = document.getElementById('branchList').innerHTML;

            // Search functionality (before and after using location)
            document.getElementById('branchSearch').addEventListener('input', function() {
                const searchQuery = this.value.toLowerCase();
                restoreOriginalBranches(); // Restore the original branches before filtering
                filterBranches(searchQuery);
                // Ensure the 'Use My Location' button is visible
                document.getElementById('useMyLocationBtn').classList.remove('d-none');
            });

            // Handle "Use My Location" button click
            document.getElementById('useMyLocationBtn').addEventListener('click', function() {
                const latitude = getCookie('latitude');
                const longitude = getCookie('longitude');

                if (latitude && longitude) {
                    // If latitude and longitude cookies exist, call the function to get the nearest branch
                    getNearestBranch(latitude, longitude);
                } else {
                    // If no cookies exist, show the access location modal
                    const modalElement = document.getElementById('modal_access');
                    if (modalElement) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    }
                }
            });

            // Function to get the nearest branch based on latitude and longitude
            function getNearestBranch(userLat, userLon) {
                $.ajax({
                    url: '/get-nearest-branch',
                    method: 'GET',
                    data: {
                        latitude: userLat,
                        longitude: userLon
                    },
                    success: function(response) {
                        const nearestBranch = response.branch;
                        displayNearestBranch(nearestBranch);
                    },
                    error: function() {
                        // Handle error if necessary
                    }
                });
            }

            // Display the nearest branch in the modal
            function displayNearestBranch(branch) {
                const branchList = document.getElementById('branchList');
                const routeUrl = routeMenuUrl.replace('__BRANCH_ID__', branch.id);

                branchList.innerHTML = `
        <a href="${routeUrl}">
            <div class="location border-bottom mb-1 branch-item">
                <div class="d-flex justify-content-between">
                    <h6 class="fw-bold mt-2 branch-name">
                        <i class="fas fa-map-marker-alt main-color mx-2"></i>${branch.name}
                    </h6>
                    <span class="badge ${branch.isOpen ? 'text-success' : 'text-muted'} mt-2">
                        ${branch.isOpen ? 'مفتوح' : 'مغلق'}
                    </span>
                </div>
                <p class="text-muted mx-2 branch-address">${branch.address}</p>
                <p class="main-color fw-bold">
                    <i class="fas fa-phone mx-2"></i>${branch.phone}
                </p>
            </div>
        </a>
    `;

                document.getElementById('useMyLocationBtn').classList.add('d-none');
                $('#branchesModal').modal('show'); // Show the modal with the branch details
            }

            // Restore the original branch list
            function restoreOriginalBranches() {
                document.getElementById('branchList').innerHTML = originalBranches;
            }

            // Filter branches based on search input
            function filterBranches(searchQuery) {
                const branches = document.querySelectorAll('.branch-item');
                branches.forEach(function(branch) {
                    const branchName = branch.querySelector('.branch-name').textContent.toLowerCase();
                    const branchAddress = branch.querySelector('.branch-address').textContent.toLowerCase();

                    if (branchName.includes(searchQuery) || branchAddress.includes(searchQuery)) {
                        branch.style.display = 'block';
                    } else {
                        branch.style.display = 'none';
                    }
                });
            }

            // Check if latitude and longitude cookies exist
            const hasLatitudeCookie = document.cookie.split('; ').some(row => row.startsWith('latitude='));
            const hasLongitudeCookie = document.cookie.split('; ').some(row => row.startsWith('longitude='));

            // If cookies don't exist, show the location access modal
            if (!hasLatitudeCookie || !hasLongitudeCookie) {
                const modalElement = document.getElementById('modal_access');
                if (modalElement) {
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }
            // Access Location Button Event Listener
            document.getElementById('accessLocationBtn').addEventListener('click', function() {
                $('#modal_access').modal('hide'); // Close the modal
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;

                        // Set cookies with the latitude and longitude
                        setCookie('latitude', latitude, 7);
                        setCookie('longitude', longitude, 7);

                        // Show the alert with the latitude and longitude
                        //alert(`Latitude: ${latitude}, Longitude: ${longitude}`);
                    }, function(error) {
                        console.error('Geolocation error:', error);
                        // Handle errors based on error code
                        switch (error.code) {
                            case error.PERMISSION_DENIED:
                                alert(
                                    'You have denied the location request. Please enable location permissions.'
                                );
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

            // Function to set cookies
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

            // Function to get cookies
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
