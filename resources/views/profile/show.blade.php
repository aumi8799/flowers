@extends('layouts.app')

@section('title', 'Vartotojo informacija')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Vartotojo informacija</h1>
            <p class="lead fw-normal text-dark-gray mb-0"></p>
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
                    <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
                </div>
                <div class="list-group">
                    <a href="/dashboard" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="far fa-tachometer-alt"></i> Skydelis
                    </a>
                    <a href="/orders" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="far fa-clipboard-list"></i> Užsakymai
                    </a>
                    <a href="#" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="fas fa-download"></i> Prenumeratos
                    </a>
                    <a href="#" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="far fa-map-marker-alt"></i> Adresai
                    </a>
                    <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                        <i class="far fa-user"></i> Vartotojo informacija
                    </a>
                    <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 0;">
                        <i class="fas fa-sign-out-alt"></i> Atsijungti
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>

            <div class="col-md-9">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    <div class="mb-4">
                        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                            @livewire('profile.update-profile-information-form')
                            <x-section-border />
                        @endif

                        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.update-password-form')
                            </div>
                            <x-section-border />
                        @endif

                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.two-factor-authentication-form')
                            </div>
                            <x-section-border />
                        @endif

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.logout-other-browser-sessions-form')
                        </div>

                        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                            <x-section-border />
                            <div class="mt-10 sm:mt-0">
                                @livewire('profile.delete-user-form')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
