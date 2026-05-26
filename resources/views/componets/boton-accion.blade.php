@props(['color' => 'blue', 'label'])

<button class="bg-{{ $color }}-500 hover:bg-{{ $color }}-600 text-white font-bold py-2 px-4 rounded">
    {{ $label }}
</button>

