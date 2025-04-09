@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('/images/premium_photo-1695297515151-b2af3a60008d.avif')">
        <div class="absolute inset-0 bg-black opacity-60"></div>
        <div class="relative container mx-auto px-4 py-24 text-center text-white">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-shadow-lg">RestoBladi Manager</h1>
            <p class="text-xl md:text-2xl mb-8 text-shadow">Plateforme de gestion pour votre restaurant marocain</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="/dashboard" class="bg-orange-600 text-white px-6 py-3 rounded-lg hover:bg-orange-700 transition duration-300 shadow-md hover:shadow-lg">
                    Accéder au tableau de bord
                </a>
                <a href="#features" class="bg-white text-orange-600 px-6 py-3 rounded-lg hover:bg-gray-100 transition duration-300 shadow-md hover:shadow-lg">
                    Découvrir les fonctionnalités
                </a>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="bg-white shadow-md sticky top-0 z-10">
        <div class="container mx-auto px-4 py-4 flex justify-center space-x-8">
            <a href="#dashboard" class="text-orange-600 font-semibold hover:text-orange-700 transition duration-300">Tableau de bord</a>
            <a href="#features" class="text-gray-600 hover:text-orange-600 transition duration-300">Fonctionnalités</a>
        </div>
    </div>

    <!-- Dashboard Preview Section -->
    <section id="dashboard" class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-6 border-b-4 border-orange-500 pb-3">Gestion Complète de Votre Restaurant</h2>
                <div class="space-y-4 text-gray-600">
                    <p class="leading-relaxed">
                        Notre application de gestion vous offre une solution complète pour gérer votre restaurant marocain.
                        Gérez vos menus, supervisez votre personnel et analysez vos performances en un seul endroit.
                    </p>
                    <p class="leading-relaxed">
                        Le tableau de bord interactif vous fournit des statistiques en temps réel sur vos ventes, vos plats vendus, vous permettant de prendre des décisions éclairées.
                    </p>
                    <p class="leading-relaxed">
                        Grâce aux rapports automatisés, vous bénéficiez d'une vue d'ensemble claire de vos activités, ce qui facilite la gestion quotidienne et l'amélioration continue de vos opérations.
                    </p>
                </div>
                <div class="grid md:grid-cols-2 gap-4 mt-6">
                    <a href="/login" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 group">
                        <h3 class="font-semibold text-orange-600 mb-2 flex items-center group-hover:text-orange-700">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm14 4H3v8a2 2 0 002 2h10a2 2 0 002-2V8z" clip-rule="evenodd"/>
                            </svg>
                            Se connecter
                        </h3>
                        <p class="text-sm">Accédez à votre espace de gestion</p>
                    </a>
                    <a href="/register" class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition duration-300 group">
                        <h3 class="font-semibold text-orange-600 mb-2 flex items-center group-hover:text-orange-700">
                            <svg class="w-5 h-5 mr-2 text-orange-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                            </svg>
                            Créer un compte
                        </h3>
                        <p class="text-sm">Commencez à utiliser notre solution</p>
                    </a>
                </div>
            </div>
            <div class="flex justify-center">
                <div class="relative rounded-xl overflow-hidden shadow-2xl bg-white p-2">
                    <img src="/images/photo-1661083098412-054431ab7112.avif"
                         alt="Application de gestion RestoBladi" 
                         class="rounded-xl max-w-full h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="bg-white py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-gray-800 mb-12 text-center border-b-4 border-orange-500 pb-3 max-w-lg mx-auto">Fonctionnalités Principales</h2>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Gestion du Personnel</h3>
                    <p class="text-gray-600">Planifiez les horaires, suivez les performances et gérez les salaires de votre équipe en quelques clics.</p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Gestion des Menus</h3>
                    <p class="text-gray-600">Conception de menus attractifs avec descriptions détaillées et images de haute qualité.Modification rapide des prix, des plats disponibles et des descriptions.</p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-gray-50 rounded-lg p-6 shadow-md hover:shadow-lg transition duration-300">
                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Rapports</h3>
                    <p class="text-gray-600">L'application permet de générer des rapports détaillés sur les ventes du jour en cours, mais avec la possibilité de voir aussi les ventes de tous les jours passés, Ces rapports offrent une vision claire et précise de l’activité commerciale du restaurant.</p>
                </div>
            </div>
            
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Prêt à optimiser la gestion de votre restaurant ?</h2>
            <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">Commencez dès aujourd'hui à utiliser notre plateforme et découvrez comment simplifier votre quotidien.</p>
            <a href="/register" class="bg-orange-600 text-white px-8 py-4 rounded-lg hover:bg-orange-700 transition duration-300 shadow-md hover:shadow-lg inline-block">
                Commencer maintenant
            </a>
        </div>
    </section>
</div>
@endsection