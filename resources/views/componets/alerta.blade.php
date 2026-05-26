@props([
    'type' => 'info',
    'message' => ''
])

@php
    // Mapeamos los colores exactos para que Tailwind los detecte siempre
    $colors = [
        'info'    => 'bg-blue-100 border-blue-400 text-blue-700',
        'success' => 'bg-green-100 border-green-400 text-green-700',
        'error'   => 'bg-red-100 border-red-400 text-red-700',
        'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-700',
    ][$type] ?? 'bg-gray-100 border-gray-400 text-gray-700';
@endphp

<div class="{{ $colors }} px-4 py-3 rounded relative border" role="alert">
    <strong class="font-bold">{{ ucfirst($type) }}!</strong>
    <span class="block sm:inline">{{ $message }}</span>
</div>