@extends('layouts.login')

@section('konten')
<div class="d-flex justify-content-center align-items-center vh-100" style="background: linear-gradient(to right, #4e73df, #1cc88a);">
    <div class="card p-4 shadow-lg" style="width: 400px; border-radius: 15px;">
        <h3 class="text-center mb-4" style="color: #1cc88a;">Login</h3>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control" name="email" placeholder="Enter your email" required autofocus style="border-radius: 10px;">
            </div>
            <div class="form-group mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Enter your password" required style="border-radius: 10px;">
            </div>
            <div class="form-group form-check mb-3">
                <input type="checkbox" class="form-check-input" name="remember" id="remember">
                <label class="form-check-label" for="remember">Remember Me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100" style="background: #1cc88a; border: none; border-radius: 10px;">Login</button>
        </form>
    </div>
</div>
@endsection
