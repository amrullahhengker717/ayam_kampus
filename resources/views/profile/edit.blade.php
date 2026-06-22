@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto 3rem;
    }
    .profile-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 1rem;
        border: 4px solid white;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        background: #eee;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        margin-left: auto;
        margin-right: auto;
    }
    .profile-card {
        background: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .profile-card h3 {
        margin-bottom: 1.5rem;
        color: var(--primary);
        border-bottom: 2px solid #f0f0f0;
        padding-bottom: 0.5rem;
    }
</style>

<div class="profile-container">
    <div class="profile-header">
        @if(auth()->user()->avatar)
            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="Avatar" class="profile-avatar">
        @else
            <div class="profile-avatar">👤</div>
        @endif
        <h2>{{ auth()->user()->name }}</h2>
        <p style="color: #666;">{{ auth()->user()->email }}</p>
    </div>

    <div class="profile-card">
        <h3>Informasi Profil</h3>
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="profile-card">
        <h3>Ubah Password</h3>
        @include('profile.partials.update-password-form')
    </div>

    <div class="profile-card" style="border: 2px solid #f8d7da;">
        <h3 style="color: #dc3545; border-bottom: 2px solid #f8d7da;">Hapus Akun</h3>
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection
