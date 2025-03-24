@extends('layouts.auth')

@section('title', 'Register')

@section('content')
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-md mx-auto bg-blue-50 shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold text-blue-800 mb-6 text-center">Créer un compte</h2>
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-blue-700">Prénom</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Entrez votre prénom"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-blue-700">Adresse e-mail</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Entrez votre e-mail"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-blue-700">Mot de passe</label>
                        <input type="password" id="password" name="password" placeholder="Entrez votre mot de passe"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('password') border-red-500 @enderror">
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-300">
                        S'inscrire
                    </button>

                    <p class="mt-4 text-center text-gray-600">
                        Vous avez déjà un compte ? <a href="{{ route('login.form') }}" class="text-blue-500 hover:underline">Connectez-vous ici</a>.
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection