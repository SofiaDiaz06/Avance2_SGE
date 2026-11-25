<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Notificaciones</h2>
    </x-slot>
    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6 space-y-4">
                @if (auth()->user()->unreadNotifications()->exists())
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="text-sm text-blue-700 underline">Marcar todas como leídas</button>
                    </form>
                @endif
                <ul class="divide-y">
                    @forelse ($notifications as $notification)
                        <li class="py-3 flex items-start justify-between gap-4 {{ $notification->read_at ? 'opacity-60' : '' }}">
                            <div>
                                <p class="font-medium">
                                    @unless ($notification->read_at)
                                        <span class="inline-block h-2 w-2 rounded-full bg-blue-600 mr-1"></span>
                                    @endunless
                                    {{ $notification->data['title'] ?? 'Notificación' }}
                                </p>
                                <p class="text-sm text-gray-600">{{ $notification->data['message'] ?? '' }}</p>
                                <p class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="text-sm text-blue-700 underline whitespace-nowrap">Abrir</button>
                            </form>
                        </li>
                    @empty
                        <li class="py-6 text-center text-gray-500">No tiene notificaciones.</li>
                    @endforelse
                </ul>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>