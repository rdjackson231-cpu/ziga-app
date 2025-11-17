<div class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-200 to-slate-300 flex items-start sm:items-center justify-center px-4 py-8">
    <div class="w-full max-w-3xl">

        {{-- Encabezado estilo Google Forms --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl sm:text-3xl font-semibold text-slate-800">
                Formulario de Registro de Paciente
            </h1>
            <p class="mt-2 text-sm sm:text-base text-slate-600">
                Ingresa los datos del paciente para crear su expediente inicial.
            </p>
        </div>

        {{-- Card principal --}}
        <div class="bg-white/95 rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- Barra superior de acento --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400"></div>

            <div class="p-5 sm:p-8 space-y-6">

                {{-- Alert de éxito --}}
                @if (session('success'))
                    <div class="mb-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Formulario --}}
                <form wire:submit.prevent="next" class="space-y-6">
                    <section class="space-y-4">
                        {{ $this->form }}
                    </section>

                    <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Verifica que los datos del paciente sean correctos antes de continuar.
                        </p>

                        <div class="flex justify-end">
                            <x-filament::button
                                type="submit"
                                class="w-full sm:w-auto justify-center"
                            >
                                Siguiente
                            </x-filament::button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('notify-link', event => {
        const url = event.detail.url;
        prompt('Copia este enlace y envíalo al paciente:', url);
    });
</script>
