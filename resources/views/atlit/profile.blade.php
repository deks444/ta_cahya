@extends('layout.main')

@section('title', 'Profile Saya')

@section('content')
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profile Saya</h1>
            <p class="text-gray-600 mt-1">Kelola informasi profil, statistik, dan prestasi Anda.</p>
        </div>

        {{-- Profile Card --}}
        <x-profile.profile-card-atlit />
        
        {{-- Points Card --}}
        <x-profile.points-card />
        
        {{-- Achievement Card --}}
        <x-profile.achievement-card />
    </div>
@endsection