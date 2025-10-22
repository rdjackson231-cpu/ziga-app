
<div class="max-w-3xl mx-auto mt-10 bg-white shadow-md rounded-lg p-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Formulario de Registro de Paciente</h2>

    @if (session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

<form wire:submit.prevent="submit" class="space-y-4">
    {{ $this->form }}
    <button type="submit"
        class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
        Enviar registro
    </button>
</form>

</div>
<script>
    window.addEventListener('notify-link', event => {
        const url = event.detail.url;
        prompt('Copia este enlace y envíalo al paciente:', url);
    });
</script>
