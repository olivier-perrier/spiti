@props(['status'])

<x-guest-layout>

    <div @class(['p-4 rounded', 'bg-yellow-500' => $status == 'warning'])>
        {{ $message }}
    </div>

</x-guest-layout>
