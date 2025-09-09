<x-app-layout>
    <div class="d-flex flex-column flex-md-row min-vh-100" style="background: linear-gradient(to bottom right, #d3ecf8, #f7fbfd);">
        @include('tourist.partials.sidebar')

        {{-- Main Content Area (Tourist Spots) --}}
        <div class="container py-5 flex-grow-1">
            <h4 class="fw-bold">TOURIST SPOTS</h4>
            <h5 class="text-muted">RECOMMENDATIONS</h5>

            <div class="container py-4">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    {{-- Tourist Spot 1: Calintaan Cave --}}
                    <div class="col">
                        <div class="card shadow rounded-3 border-0 h-100">
                            <img src="{{ asset('images/calintaan_cave.png') }}" class="card-img-top rounded-top" alt="Calintaan Cave" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-light d-flex flex-column">
                                <h5 class="fw-bold mb-0">Calintaan Cave</h5>
                                <p class="card-text text-muted small mb-1">Located in Juban, Sorsogon</p>
                                <p class="card-text small mt-2">Explore the natural rock formations and hidden wonders within Calintaan Cave, a captivating geological site.</p>
                                <div class="mt-auto text-end">
                                    <a href="#" class="btn btn-primary btn-sm" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tourist Spot 2: Balay ni Verlyn --}}
                    <div class="col">
                        <div class="card shadow rounded-3 border-0 h-100">
                            <img src="{{ asset('images/balay_ni_verlyn.png') }}" class="card-img-top rounded-top" alt="Balay ni Verlyn" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-light d-flex flex-column">
                                <h5 class="fw-bold mb-0">Balay ni Verlyn</h5>
                                <p class="card-text text-muted small mb-1">Located in Bulan, Sorsogon</p>
                                <p class="card-text small mt-2">A cozy and welcoming spot offering local delicacies and a glimpse into Bulan's charm.</p>
                                <div class="mt-auto text-end">
                                    <a href="#" class="btn btn-primary btn-sm" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tourist Spot 3: Juag Lagoon Fish Sanctuary --}}
                    <div class="col">
                        <div class="card shadow rounded-3 border-0 h-100">
                            <img src="{{ asset('images/juag_lagoon.png') }}" class="card-img-top rounded-top" alt="Juag Lagoon Fish Sanctuary" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-light d-flex flex-column">
                                <h5 class="fw-bold mb-0">Juag Lagoon Fish Sanctuary</h5>
                                <p class="card-text text-muted small mb-1">Located in Matnog, Sorsogon</p>
                                <p class="card-text small mt-2">Discover vibrant marine life and diverse fish species in this well-preserved sanctuary.</p>
                                <div class="mt-auto text-end">
                                    <a href="#" class="btn btn-primary btn-sm" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tourist Spot 4: Subic Beach --}}
                    <div class="col">
                        <div class="card shadow rounded-3 border-0 h-100">
                            <img src="{{ asset('images/subic_beach.png') }}" class="card-img-top rounded-top" alt="Subic Beach" style="height: 200px; object-fit: cover;">
                            <div class="card-body bg-light d-flex flex-column">
                                <h5 class="fw-bold mb-0">Subic Beach</h5>
                                <p class="card-text text-muted small mb-1">Located in Matnog, Sorsogon</p>
                                <p class="card-text small mt-2">Relax on the pristine pinkish-white sands of Subic Beach, a tranquil tropical paradise.</p>
                                <div class="mt-auto text-end">
                                    <a href="#" class="btn btn-primary btn-sm" style="background-color:rgb(9, 135, 219); border-color: rgb(9, 135, 219);">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom CSS for sidebar nav-link hover and focus */
        .nav-link.text-white:hover,
        .nav-link.text-white:focus,
        .nav-link.text-white.active {
            background-color: rgb(6, 58, 170) !important; /* Maroon Red */
        }

        /* Styles for the content cards */
        .card {
            border: 1px solid #e0e0e0;
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .card-img-top {
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .card-body {
            padding: 1rem;
            background-color: var(--bs-light);
        }
        .card-title {
            font-weight: bold;
            color: #333;
            font-size: 1.15rem;
        }
        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .btn-primary {
            color: #fff;
        }
        .btn-primary:hover {
            background-color: rgb(5, 95, 155) !important;
            border-color: rgb(5, 95, 155) !important;
        }
        .flex-grow-1 {
            flex-grow: 1;
        }
        .h-100.d-flex.flex-column {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
    </style>

    {{-- Custom JavaScript for mobile sidebar behavior --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var mobileSidebar = document.getElementById('mobileSidebar');
            if (mobileSidebar) {
                var offcanvas = new bootstrap.Offcanvas(mobileSidebar);

                function hideOffcanvasOnDesktop() {
                    // Bootstrap's 'md' breakpoint is 768px
                    if (window.innerWidth >= 768) {
                        offcanvas.hide();
                    }
                }

                // Hide offcanvas immediately if screen is already desktop size on load
                hideOffcanvasOnDesktop();

                // Add event listener for window resize
                window.addEventListener('resize', hideOffcanvasOnDesktop);
            }
        });
    </script>
</x-app-layout>