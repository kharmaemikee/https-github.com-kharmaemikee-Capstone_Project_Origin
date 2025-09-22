<x-explore-layout>
    <x-slot name="header">
        <h2 class="h4 font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Kuya Boy Beach Resort') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row">
            <div class="col-md-12">
                <h1>Kuya Boy Beach Resort</h1>
                <hr>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 g-4">
            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body bg-warning text-dark">
                        <h5 class="card-title d-none d-md-block fw-bold">RESERVATION DETAILS</h5>
                        <h6 class="card-title d-md-none fw-bold">RESERVATION</h6>
                        <div class="row">
                            <div class="col-6">
                                <p class="card-text mb-1"><strong>Check-In</strong></p>
                                <p class="card-text">{{ \Carbon\Carbon::parse('2025-12-27')->format('D d/m/Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="card-text mb-1"><strong>Check-Out</strong></p>
                                <p class="card-text">{{ \Carbon\Carbon::parse('2025-05-02')->format('D d/m/Y') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="card-text mb-1"><strong>Total Nights</strong></p>
                                <p class="card-text">6</p>
                            </div>
                            <div class="col-6">
                                <p class="card-text mb-1"><strong>Total Rooms</strong></p>
                                <p class="card-text">2</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="card-text mb-1"><strong>Total Guests</strong></p>
                                <p class="card-text">2 ADULTS 0 CHILDREN</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card shadow-sm">
                    <div class="card-body bg-light">
                        <h5 class="card-title d-none d-md-block fw-bold text-secondary">AVAILABLE ROOMS</h5>
                        <h6 class="card-title d-md-none fw-bold text-secondary">ROOMS</h6>
                        @for ($i = 0; $i < 4; $i++)
                            <div class="row g-0 align-items-center mb-3">
                                <div class="col-md-4">
                                    <img src="{{ asset('images/kuyaboyLOGO.png') }}" alt="Regular Room" class="img-fluid rounded-start" style="object-fit: cover; height: 100%;">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h6 class="card-subtitle mb-2 text-muted fw-bold">REGULAR ROOM</h6>
                                        <p class="card-text">This is our regular rooms for only low prices.</p>
                                        <p class="card-text"><strong>500.00 Pesos / for 1 day</strong></p>
                                        <button class="btn btn-primary btn-sm float-end book-now-btn" style="background-color: #00bfff; border-color: #00bfff;" data-bs-toggle="modal" data-bs-target="#registerModal">BOOK NOW</button>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

   <!-- Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Login or Register</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>You need to login or register first before you can book a room.</p>
                <div class="d-grid gap-2">
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-success">Register</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



</x-explore-layout>

<style>
    .card-title {
        margin-bottom: 1rem;
    }
    .card-subtitle {
        color: #6c757d !important;
    }
    .card-text strong {
        font-weight: bold;
    }
    .btn-primary {
        color: #fff;
    }
    .btn-primary:hover {
        background-color: #0099cc;
        border-color: #0099cc;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bookNowButtons = document.querySelectorAll('.book-now-btn');

        bookNowButtons.forEach(button => {
            button.addEventListener('click', function() {
                // The modal will open automatically due to the data-bs-toggle and data-bs-target attributes.
            });
        });
    });
</script>