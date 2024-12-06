<div class="col-lg-12">
    <!--begin::Card-->
    <div class="card card-custom gutter-b">
        <div class="card-header">
            <div class="card-title">
                <h3 class="card-label">Core Data Disperse on Map</h3>
            </div>
        </div>
        <div class="card-body">
            <!--begin::Chart-->
            <div id="core-group-map-chart" class="d-flex justify-content-center"></div>
            <!--end::Chart-->
        </div>
    </div>
    <!--end::Card-->
</div>
@push('css')
    <style>
        #core-group-map-chart {
            height: 100vh;
            width: 100%;
        }
    </style>
@endpush
@push('js')
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("core-group-map-chart"), {
                zoom: 6,
                center: {
                    lat: 9.145,
                    lng: 40.489673
                }, // Ethiopia's approximate center
            });

            // Fetch grouped data via AJAX
            $.ajax({
                url: "/core-group-map-chart", // Update with your route
                method: "GET",
                success: function(data) {
                    data.forEach((location) => {
                        // Create markers for each grouped location
                        const marker = new google.maps.Marker({
                            position: {
                                lat: parseFloat(location.gps_latitude),
                                lng: parseFloat(location.gps_longitude)
                            },
                            map: map,
                        });

                        // Add an info window for each marker
                        const infoWindow = new google.maps.InfoWindow({
                            content: `
                            <div>
                                <h4>Location Details</h4>
                                <p><b>GPS Coordinates:</b> ${location.gps_latitude}, ${location.gps_longitude}</p>
                                <p><b>Record Count:</b> ${location.record_count}</p>
                                <p><b>Regions:</b> ${location.regions}</p>
                                <p><b>Villages:</b> ${location.villages}</p>
                            </div>
                        `,
                        });

                        // Show info window on marker click
                        marker.addListener("click", () => {
                            infoWindow.open(map, marker);
                        });
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching grouped location data:", error);
                },
            });
        }
    </script>
@endpush
