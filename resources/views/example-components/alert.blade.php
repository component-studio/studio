@studio([
    'data' => [
        'content' => 'This is the content inside the notification',
        'title' => 'Notification Title',
        'type' => 'info',
        'size' => 'normal'
    ]
])

@props([
    'title' => 'Notification Title',
    'type' => 'info', // info, success, warning, danger
    'size' => 'default' // normal, sm
])

@php

    $alertIcon = 'icon-info-duotone';

    $alertIcon = match($type)
    {
        'info' => 'icon-info-duotone',
        'success' => 'icon-check-circle-duotone',
        'warning' => 'icon-warning-duotone',
        'danger' => 'icon-warning-circle-duotone',
    };


@endphp

<div
    x-data="{ closed: false }"
    x-show="!closed"
    @class([
        'rounded-lg min-w-[300px] flex flex-col justify-center items-center w-full ',
        'p-3' => $size == 'sm',
        'p-4' => $size != 'sm',
		'bg-blue-50 text-blue-700' => $type == 'info',
		'bg-green-50 text-green-500' => $type == 'success',
		'bg-yellow-50 text-yellow-500' => $type == 'warning',
		'bg-coral-50 text-coral-600' => $type == 'danger'
    ])
>
    <h4 class="flex gap-2 flex-1 justify-between items-center self-stretch w-full">
        <span class="gap-2 flex items-center flex-1">
            {{-- <x-icon :icon="$alertIcon" class="w-6 h-6" /> --}}
            <span>{{ $title }}</span>
        </span>
        <span
			@class([
				'w-6 h-6 cursor-pointer rounded-full flex items-center justify-center',
				'hover:bg-blue-100' => $type == 'info',
				'hover:bg-green-100' => $type == 'success',
				'hover:bg-yellow-100' => $type == 'warning',
				'hover:bg-coral-100' => $type == 'danger'
			])
			@click="closed=true"
		>

            {{-- <x-icon icon="icon-x-bold" class="w-4 h-4" /> --}}
        </span>
    </h4>
    @if ($size != 'sm')
        <div class="pl-8 pr-10 flex gap-0 justify-start items-start self-stretch w-full">
            <p class="font-normal leading-6 text-base opacity-70">{{ $slot ?? '' }}</p>
        </div>
    @endif
</div>
