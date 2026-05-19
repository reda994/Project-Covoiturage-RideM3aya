@extends('layouts.app')

@section('title', 'Mes messages')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8 mt-16">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8 animate-fade-in">Mes messages</h1>
    
    @if($messages->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl p-12 text-center border border-gray-100 dark:border-gray-700 animate-fade-in">
            <div class="w-20 h-20 mx-auto bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-6">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Aucun message</h3>
            <p class="text-gray-500 dark:text-gray-400">Vous n'avez pas encore reçu de messages.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($messages as $message)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition animate-slide-left {{ $message->is_read ? 'opacity-75' : '' }}">
                    <div class="flex items-start gap-4">
                        <img src="{{ $message->sender->profile_photo_url }}" class="w-12 h-12 rounded-full border-2 border-green-500">
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $message->sender->name }}</h3>
                                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $message->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            @if($message->trip)
                                <p class="text-sm text-green-600 dark:text-green-400 mb-2">Trajet: {{ $message->trip->departure_city }} → {{ $message->trip->arrival_city }}</p>
                            @endif
                            <p class="text-gray-700 dark:text-gray-300">{{ $message->content }}</p>
                            @if(!$message->is_read)
                                <span class="inline-block mt-2 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium">Nouveau</span>
                            @endif
                        </div>
                        <a href="{{ route('trips.show', $message->trip_id) }}" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition text-sm font-medium">
                            Voir le trajet
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
