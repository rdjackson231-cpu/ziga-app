<div class="max-w-2xl mx-auto p-8 text-center">
    <div class="mx-auto mb-6 w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 12l2 2 4-4M7 12a5 5 0 1110 0 5 5 0 01-10 0z" />
        </svg>
    </div>

    <h1 class="text-2xl font-semibold mb-2">¡Registro completado!</h1>
    <p class="text-gray-600 mb-6">
        Gracias. La información fue guardada correctamente.
    </p>

    <div class="flex items-center justify-center gap-3">
        <a href="{{ route('public.patient') }}" class="px-4 py-2 rounded bg-gray-100 hover:bg-gray-200 text-gray-800">
            Capturar otro paciente
        </a>

        <a href="/" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white">
            Volver al inicio
        </a>
    </div>

    {{-- Opcional: mensaje de ayuda --}}
    <p class="text-sm text-gray-500 mt-6">
        Si necesitas hacer correcciones, vuelve a la página anterior o contacta a soporte.
    </p>
</div>
