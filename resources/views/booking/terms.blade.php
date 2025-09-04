{{-- resources/views/booking/terms.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Terms and Conditions</h4>
        </div>
        <div class="card-body">
            <p>Welcome to our tourism platform. By accessing or using our services, you agree to the following terms and conditions:</p>

            <h5>1. Acceptance of Terms</h5>
            <p>By registering, browsing, or using our platform, you confirm that you have read, understood, and agree to be bound by these terms.</p>

            <h5>2. User Responsibilities</h5>
            <ul>
                <li>You must provide accurate and complete information when creating an account.</li>
                <li>You are responsible for maintaining the confidentiality of your account credentials.</li>
                <li>You agree not to engage in any fraudulent, abusive, or illegal activity using the platform.</li>
            </ul>

            <h5>3. Content Ownership</h5>
            <p>All content posted on the site is the property of its respective owners. You may not use, copy, or distribute content without permission.</p>

            <h5>4. Termination</h5>
            <p>We reserve the right to suspend or terminate your account if you violate any of these terms or engage in conduct deemed harmful to the platform.</p>

            <h5>5. Limitation of Liability</h5>
            <p>We are not liable for any damages resulting from your use of the platform, including but not limited to loss of data or service interruptions.</p>

            <h5>6. Changes to Terms</h5>
            <p>We may update these terms at any time. Continued use of the platform indicates your acceptance of any changes.</p>

            <p class="mt-4">If you have any questions or concerns regarding these terms, please contact our support team.</p>

            <div class="text-end mt-4">
                <a href="{{ route('booking.terms') }}" class="btn btn-primary">Back to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
