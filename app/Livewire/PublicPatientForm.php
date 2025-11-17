<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\MedicalRecord;
use Filament\Forms;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;


class PublicPatientForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected string $layout = 'layouts.app';

    public ?Patient $patient = null;
    public ?MedicalRecord $medicalRecord = null;

    public ?array $data = [];
    public string $token;

    public function mount(?string $token = null): void
    {
        // si no viene token en la URL, genera uno para esta sesión de registro
        $this->token = $token ?: Str::uuid()->toString();

        $this->patient = Patient::firstOrNew(['token' => $this->token]);

        if ($this->patient->exists) {
            $this->medicalRecord = MedicalRecord::where('patient_id', $this->patient->id)->first();
        }

        $this->form->fill($this->patient->toArray());
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('first_name')->label('Nombre')->required(),
            Forms\Components\TextInput::make('middle_name')->label('Segundo nombre'),
            Forms\Components\TextInput::make('last_name')->label('Apellido paterno')->required(),
            Forms\Components\TextInput::make('second_last_name')->label('Apellido materno'),
            Forms\Components\Select::make('gender')
                ->label('Género')
                ->options([
                    'Masculino' => 'Masculino',
                    'Femenino' => 'Femenino',
                    'Otro' => 'Otro',
                ])
                ->required(),
            Forms\Components\DatePicker::make('birth_date')->label('Fecha de nacimiento')->required(),
            Forms\Components\TextInput::make('age')->numeric()->label('Edad')->suffix('años'),
            Forms\Components\TextInput::make('blood_type')->label('Tipo de sangre'),
            Forms\Components\TextInput::make('email')->email()->label('Correo electrónico'),
            Forms\Components\TextInput::make('phone')->label('Teléfono'),
            Forms\Components\Textarea::make('address')->label('Dirección')->rows(2),
            Forms\Components\TextInput::make('emergency_contact_name')->label('Nombre contacto emergencia'),
            Forms\Components\TextInput::make('emergency_contact_phone')->label('Teléfono contacto emergencia'),
        ];
    }

    /** Botón “Siguiente”: guarda Patient, asegura MedicalRecord y redirige al form de Historia Clínica */
public function next()
{
    // Lee el estado actual del formulario (más confiable que $this->data)
    $state = $this->form->getState();

    // Validación mínima (evita NOT NULL violations)
    if (
        blank($state['first_name'] ?? null) ||
        blank($state['last_name'] ?? null) ||
        blank($state['gender'] ?? null) ||
        blank($state['birth_date'] ?? null)
    ) {
        $this->addError('data._required', 'Completa los campos obligatorios (Nombre, Apellido paterno, Género, Fecha de nacimiento).');
        return back();
    }

    // Asegura token en el modelo
    if (!$this->patient->token) {
        $this->patient->token = $this->token ?: Str::uuid()->toString();
    }

    // Guarda/actualiza paciente con el estado del form
    $this->patient->fill([
        'registered_at'           => now(),
        'first_name'              => $state['first_name'],
        'middle_name'             => $state['middle_name'] ?? null,
        'last_name'               => $state['last_name'],
        'second_last_name'        => $state['second_last_name'] ?? null,
        'gender'                  => $state['gender'],
        'age'                     => $state['age'] ?? null,
        'birth_date'              => $state['birth_date'],
        'blood_type'              => $state['blood_type'] ?? null,
        'address'                 => $state['address'] ?? null,
        'email'                   => $state['email'] ?? null,
        'phone'                   => $state['phone'] ?? null,
        'emergency_contact_name'  => $state['emergency_contact_name'] ?? null,
        'emergency_contact_phone' => $state['emergency_contact_phone'] ?? null,
    ])->save();

    // Asegura/crea expediente
    $this->medicalRecord = $this->medicalRecord
        ?: MedicalRecord::firstOrCreate(
            ['patient_id' => $this->patient->id],
            ['token' => Str::uuid()->toString()]
        );

    // Si existía sin token, asígnalo ahora
    if (blank($this->medicalRecord->token)) {
        $this->medicalRecord->token = Str::uuid()->toString();
        $this->medicalRecord->save();
    }

    // Redirige al form de historia clínica con el token del expediente
    $this->redirectRoute('public.clinical-history', ['mrToken' => $this->medicalRecord->token], navigate: true);
}
    public function render()
    {
        return view('livewire.public-patient-form');
    }
}
