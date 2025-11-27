<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Formulario Público' }}</title>

    {{-- Livewire --}}
    @livewireStyles

    {{-- Tailwind para el layout y utilidades --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Estilos de Filament Forms + Support por CDN --}}
    <link rel="stylesheet" href="https://unpkg.com/@filament/forms@3.0.0/dist/filament-forms.css">
    <link rel="stylesheet" href="https://unpkg.com/@filament/support@3.0.0/dist/filament-support.css">
</head>

<body class="bg-gray-100 antialiased min-h-screen">
    {{-- Contenido de tus componentes Livewire --}}
    {{ $slot }}

    {{-- Scripts Livewire --}}
    @livewireScripts

    {{-- JS de Filament (para addRow, repeaters, etc.) --}}
    @filamentScripts
</body>
</html>
