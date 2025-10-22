<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Patient;
use Filament\Forms;
use Filament\Schemas\Schema;

class PublicPatientForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    protected string $layout = 'layouts.app';

    public ?Patient $patient = null;
    public ?array $data = [];
    public string $token;

 public function mount($token)
{
    $this->token = $token;
    $this->patient = Patient::firstOrNew(['token' => $token]);

    $this->form->fill($this->patient->toArray());
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


    public function submit(): void
    {
        $this->patient->fill([
            'registered_at' => now(),
            'first_name' => $this->data['first_name'],
            'middle_name' => $this->data['middle_name'] ?? null,
            'last_name' => $this->data['last_name'],
            'second_last_name' => $this->data['second_last_name'] ?? null,
            'gender' => $this->data['gender'],
            'age' => $this->data['age'] ?? null,
            'birth_date' => $this->data['birth_date'],
            'blood_type' => $this->data['blood_type'] ?? null,
            'address' => $this->data['address'] ?? null,
            'email' => $this->data['email'] ?? null,
            'phone' => $this->data['phone'] ?? null,
            'emergency_contact_name' => $this->data['emergency_contact_name'] ?? null,
            'emergency_contact_phone' => $this->data['emergency_contact_phone'] ?? null,
        ])->save();

        session()->flash('success', '¡Registro completado correctamente!');
        $this->form->fill([]);
    }

    public function render()
    {
        return view('livewire.public-patient-form');
    }

}
