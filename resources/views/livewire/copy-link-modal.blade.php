<div class="p-4">
    <p class="text-gray-700 mb-2">
        Copia este enlace y envíalo al paciente:
    </p>

    <div class="flex items-center gap-2">
        <input
            type="text"
            readonly
            value="{{ $url }}"
            class="w-full border rounded px-3 py-2 text-sm text-gray-700"
            id="public-link"
        >
        <button
            type="button"
            onclick="navigator.clipboard.writeText('{{ $url }}'); alert('¡Link copiado al portapapeles!')"
            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-sm"
        >
            Copiar
        </button>
    </div>
</div>
