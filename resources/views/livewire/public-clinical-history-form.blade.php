<div class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">
    <div class="w-full max-w-3xl">
        <div class="bg-white shadow-lg rounded-xl p-6 sm:p-8 space-y-6">

            {{-- Encabezado --}}
            <header class="text-center space-y-2">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                    Historia Clínica
                </h1>
                <p class="text-sm text-gray-500">
                    Completa la información para registrar o actualizar la historia clínica del paciente.
                </p>
            </header>

            {{-- Sección: Datos del expediente --}}
            <section class="border rounded-lg p-4 sm:p-5 bg-gray-50">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-2">
                    Datos del Expediente
                </h2>

                <div class="text-sm text-gray-700 flex flex-wrap gap-2">
                    <span>Expediente:</span>
                    <strong class="font-semibold">
                        {{ $medicalRecord->code ?? ('#' . $medicalRecord->id) }}
                    </strong>
                </div>
            </section>

            {{-- Sección: Formulario (campos de Filament) --}}
            <section class="border rounded-lg p-4 sm:p-5">
                <h2 class="text-base sm:text-lg font-semibold text-gray-800 mb-4">
                    Información Clínica
                </h2>

                <form wire:submit.prevent="submit" class="space-y-4">
                    {{-- Aquí se renderizan los campos definidos en el form de Filament --}}
                    <div class="space-y-4">
                        {{ $this->form }}
                    </div>

                    {{-- Sección: Acciones --}}
                    <div class="pt-4 border-t flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3">
                        <x-filament::button
                            type="submit"
                            class="w-full sm:w-auto justify-center"
                        >
                            Guardar
                        </x-filament::button>
                    </div>
                </form>
            </section>

        </div>
    </div>
</div>
