@extends('admin.layouts.app')

@section('page-title', 'User Profile')

@section('content')
    <x-common.page-breadcrumb pageTitle="User Profile" />
    <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03] lg:p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800 dark:text-white/90 lg:mb-7">Profile</h3>

        {{-- Profile Card - Shown for all roles --}}
        <x-profile.profile-card />

        @if(Auth::user()->role === 'atlit')
            {{-- Points Card - Only for Atlit --}}
            <x-profile.points-card />

            {{-- Achievement Card - Only for Atlit --}}
            <x-profile.achievement-card />
        @endif
    </div>
@endsection