@extends('layouts.auth')

@section('title', 'Восстановление пароля')

@section('content')
<x-forms.auth-forms
        title="Забыли пароль"
        action="{{ route('password-reset.handle') }}"
        method="POST">
    @csrf
    <x-forms.text-input name="email"
                        :isError="$errors->has('email')"
                        type="email"
                        placeholder="E-mail"
                        value="{{ request('email') }}"
                        required="true" />
    <input type="hidden" name="token" value="{{ $token }}" />
    @error('email')
    <x-forms.error>{{ $message }}</x-forms.error>
    @enderror

    <x-forms.text-input name="password"
                        :isError="$errors->has('password')"
                        type="password"
                        placeholder="Пароль"
                        required="true" />
    @error('password')
    <x-forms.error>{{ $message }}</x-forms.error>
    @enderror
    <x-forms.text-input name="password_confirmation"
                        :isError="$errors->has('password_confirmation')"
                        type="password"
                        placeholder="Подтверждение пароля"
                        required="true" />

    <x-forms.primary-button>Сохранить</x-forms.primary-button>


    <x-slot:buttons></x-slot:buttons>
    <x-slot:socialAuth></x-slot:socialAuth>
</x-forms.auth-forms>
@endsection