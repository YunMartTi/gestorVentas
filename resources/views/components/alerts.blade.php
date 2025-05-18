@props(['type' => 'info'])

@php
    switch ($type) {
        case 'info':
            # code...
            $class = 'text-blue-800 bg-blue-50';
            break;
        case 'danger':
            # code...
            $class = 'text-red-800 bg-red-50';
            break;
        case 'success':
            # code...
            $class = 'text-green-800 bg-green-50';
            break;
        case 'warning':
            # code...
            $class = 'text-yellow-800 bg-yellow-50';
            break;
        case 'dark':
            # code...
            $class = 'text-gray-800 bg-gray-50';
            break;
        default:
            $class = 'text-blue-800 bg-blue-50';
            break;
    }
@endphp

<div {{$attributes->merge(['class' =>'p-4 text-sm rounded-lg ' . $class])}} role="alert">
    <span class="font-medium">{{$title ?? 'Info Alert!'}}!</span> {{$slot}}.
</div>