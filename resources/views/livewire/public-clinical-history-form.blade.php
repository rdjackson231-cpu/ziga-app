{{-- resources/views/livewire/public-clinical-history-form.blade.php --}}

<div class="min-h-screen bg-gradient-to-br from-slate-100 via-slate-200 to-slate-300 flex items-start sm:items-center justify-center px-4 py-8">
    <div class="w-full max-w-3xl">

        {{-- Encabezado estilo Google Forms --}}
        <div class="mb-6 text-center">
            <h1 class="text-2xl sm:text-3xl font-semibold text-slate-800">
                Historia Clínica
            </h1>
            <p class="mt-2 text-sm sm:text-base text-slate-600">
                Completa la información clínica del paciente.  
                Los campos marcados como obligatorios deben llenarse para guardar el formulario.
            </p>
        </div>

        {{-- Card principal --}}
        <div class="bg-white/95 rounded-2xl shadow-xl border border-slate-200 overflow-hidden">

            {{-- Barra superior de acento --}}
            <div class="h-1.5 bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400"></div>

            <div class="p-5 sm:p-8 space-y-6">

                {{-- Sección: Datos del expediente --}}
                <section class="rounded-xl bg-slate-50 border border-slate-200 px-4 py-3 sm:px-5 sm:py-4">
                    <div class="flex flex-col sm:flex-row sm:items-baseline sm:justify-between gap-2">
                        <div>
                            <h2 class="text-sm font-semibold text-slate-800">
                                Datos del expediente
                            </h2>
                            <p class="text-xs text-slate-500">
                                Información de referencia para este registro.
                            </p>
                        </div>

                        <div class="text-sm sm:text-base text-slate-700">
                            <span class="text-xs uppercase tracking-wide text-slate-400">Expediente</span>
                            <div class="font-semibold text-slate-900">
                                {{ $medicalRecord->code ?? ('#' . $medicalRecord->id) }}
                            </div>
                        </div>
                    </div>
                </section>

                {{-- Formulario Filament --}}
                <form wire:submit.prevent="submit" class="space-y-6">

                    <section class="space-y-4">
                        {{-- Aquí Filament renderiza todos los campos --}}
                        {{ $this->form }}
                    </section>

                    {{-- Footer / acciones --}}
                    <div class="pt-4 border-t border-slate-200 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-4">
                        <p class="text-xs text-slate-500">
                            Revisa la información antes de guardar.  
                            Puedes actualizar este registro posteriormente si es necesario.
                        </p>

                        <div class="flex gap-3 justify-end">
                            {{-- Si quieres un botón secundario en el futuro, va aquí --}}
                            <x-filament::button
                                type="submit"
                                class="w-full sm:w-auto justify-center"
                            >
                                Guardar
                            </x-filament::button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
