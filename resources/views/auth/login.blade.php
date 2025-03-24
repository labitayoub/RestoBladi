@extends('layouts.auth')

@section('title', 'Login')

@section('content')

    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-blue-50 shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold text-blue-800 mb-6 text-center">Connectez-vous à votre compte</h2>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-blue-700">Adresse e-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Entrez votre e-mail"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-blue-700">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6 flex items-center justify-between">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}
                                class="form-checkbox h-5 w-5 text-blue-500">
                            <span class="ml-2 text-blue-700">Se souvenir de moi</span>
                        </label>

                        <a href="#" class="text-blue-500 hover:underline">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                        Connexion
                    </button>

                    <p class="mt-4 text-center text-gray-600">
                        Vous n'avez pas de compte ? <a href="{{ route('register.form') }}"
                            class="text-blue-500 hover:underline">Inscrivez-vous ici</a>.
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection