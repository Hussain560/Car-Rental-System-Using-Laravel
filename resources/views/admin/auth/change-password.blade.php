@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h4 class="text-center mb-4">Change Password</h4>
                    
                    <form action="{{ route('admin.password.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" 
                                   class="form-control @error('new_password') is-invalid @enderror" 
                                   name="new_password" 
                                   required>
                            @error('new_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Confirm New Password</label>
                            <input type="password" 
                                   class="form-control" 
                                   name="new_password_confirmation" 
                                   required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Change Password
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
