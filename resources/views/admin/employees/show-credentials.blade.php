@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="min-vh-100 d-flex align-items-center justify-content-center">
        <div class="card shadow-lg border-0" style="width: 500px;">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="bi bi-person-check-fill text-success" style="font-size: 3rem;"></i>
                </div>

                <h3 class="mb-4">Employee Created Successfully!</h3>

                <div class="alert alert-info p-4 mb-4 text-start">
                    <div class="mb-4">
                        <label class="form-label fw-bold mb-2">Username:</label>
                        <div class="bg-light p-3 rounded">
                            <code class="fs-5">{{ $username }}</code>
                        </div>
                    </div>
                    <div>
                        <label class="form-label fw-bold mb-2">Generated Password:</label>
                        <div class="bg-light p-3 rounded">
                            <code class="fs-5">{{ $password }}</code>
                        </div>
                    </div>
                </div>

                <div class="progress mb-3" style="height: 4px;">
                    <div class="progress-bar" id="countdown-progress" style="width: 100%"></div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small class="text-muted">
                        Redirecting in <span id="countdown" class="fw-bold">30</span> seconds
                    </small>
                    <button onclick="copyCredentials()" class="btn btn-sm btn-primary">
                        <i class="bi bi-clipboard me-1"></i> Copy Credentials
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                        Return to Employees List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let timeLeft = 30;
    const countdownEl = document.getElementById('countdown');
    const progressBar = document.getElementById('countdown-progress');
    
    const timer = setInterval(() => {
        timeLeft--;
        countdownEl.textContent = timeLeft;
        progressBar.style.width = ((timeLeft / 30) * 100) + '%';
        
        if (timeLeft <= 0) {
            clearInterval(timer);
            window.location.href = "{{ route('admin.employees.index') }}";
        }
    }, 1000);

    function copyCredentials() {
        const credentials = `Username: {{ $username }}\nPassword: {{ $password }}`;
        navigator.clipboard.writeText(credentials).then(() => {
            alert('Credentials copied to clipboard!');
        });
    }

    // Remove the beforeunload event listener
    window.onbeforeunload = null;
</script>
@endpush
@endsection
