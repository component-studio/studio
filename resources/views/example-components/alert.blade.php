@props([
    'title' => 'Notification Titler',
    'type' => 'info', // info, success, warning, danger
    'size' => 'default' // normal, sm
])

<div
    x-data="{ closed: false }"
    x-show="!closed"
    @class([
        'rounded-lg max-w-xl w-full space-y-2',
        'p-4' => $size == 'sm',
        'p-5' => $size != 'sm',
		'bg-blue-50 text-blue-700' => $type == 'info',
		'bg-green-50 text-green-500' => $type == 'success',
		'bg-yellow-50 text-yellow-500' => $type == 'warning',
		'bg-coral-50 text-coral-600' => $type == 'danger'
    ])
>
    <h4 class="flex flex-1 gap-2 justify-between items-center self-stretch w-full leading-none">
        <span class="flex flex-1 gap-2 items-center">
            <span>{{ $title }}</span>
        </span>
    </h4>
    @if ($size != 'sm')
        <div class="flex gap-0 justify-start items-start self-stretch pr-10 w-full">
            <p class="text-base font-normal leading-6 opacity-60">{{ $slot ?? '' }}</p>
        </div>
    @endif
</div>
