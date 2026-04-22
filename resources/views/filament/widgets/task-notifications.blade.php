<x-filament::section>
    <x-slot name="heading">
        🔔 Thông báo công việc
    </x-slot>

    <div class="space-y-3">
        @forelse ($notifications as $notification)
            @php
                $type = $notification->data['type'] ?? 'info';

                $styles = [
                    'overdue' => [
                        'bg' => 'bg-red-50 border-red-200',
                        'text' => 'text-red-600',
                        'label' => 'Quá hạn',
                        'icon' => '❌',
                    ],
                    'upcoming' => [
                        'bg' => 'bg-yellow-50 border-yellow-200',
                        'text' => 'text-yellow-600',
                        'label' => 'Sắp tới hạn',
                        'icon' => '⏰',
                    ],
                    'info' => [
                        'bg' => 'bg-gray-50 border-gray-200',
                        'text' => 'text-gray-600',
                        'label' => 'Thông báo',
                        'icon' => '🔔',
                    ],
                ];

                $style = $styles[$type] ?? $styles['info'];
            @endphp

            <div class="p-4 rounded-xl border {{ $style['bg'] }} hover:shadow transition">

                <div class="flex justify-between items-start">
                    <div>
                        <div class="font-semibold text-sm">
                            {{ $style['icon'] }} {{ $notification->data['title'] ?? 'Task' }}
                        </div>

                        <div class="text-xs text-gray-600 mt-1">
                            {{ $notification->data['message'] ?? '' }}
                        </div>
                    </div>

                    <span class="text-[11px] px-2 py-1 rounded-full font-medium {{ $style['text'] }} bg-white border">
                        {{ $style['label'] }}
                    </span>
                </div>

                <div class="text-[11px] text-gray-400 mt-2">
                    {{ $notification->created_at->diffForHumans() }}
                </div>

            </div>
        @empty
            <div class="text-gray-400 text-sm text-center py-6">
                🎉 Không có thông báo nào
            </div>
        @endforelse
    </div>
</x-filament::section>