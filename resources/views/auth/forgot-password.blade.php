@extends('layouts.main')
@section('content')
<div class="mb-4 text-sm  text-dark">
    {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will   allow you to choose a new one.') }}
</div>

<!-- Session Status -->
<x-auth-session-status class="mb-4" :status="session('status')" />

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email :')" style="font-size: 16px;" />
        <x-text-input id="email" class="block mt-1 w-full form-control" type="email" name="email" :value="old('email')" style="background-color: rgb(243, 252, 252)" required autofocus />
        <x-input-error :messages="$errors->get('email')" class="mt-2" />
    </div>

    <div class="flex items-center justify-end mt-4">
        <x-primary-button class="rounded">
            {{ __('Email Password Reset Link') }}
        </x-primary-button>
    </div>
</form>
@endsection