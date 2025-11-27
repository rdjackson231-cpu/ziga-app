<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

// Filament 4 (API de Schemas)
use Filament\Schemas\Schema as FilamentSchema;
use Filament\Forms;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\KeyValue;

use App\Models\MedicalRecord;
use App\Models\ClinicalHistory;

class PublicClinicalHistoryForm extends Component implements HasForms
{
    use InteractsWithForms;

    protected string $layout = 'layouts.app';

    public ?MedicalRecord $medicalRecord = null;
    public string $mrToken;

    /** Estado del formulario */
    public ?array $data = [];

    /** Carga el expediente por token desde la URL */
    public function mount(string $mrToken): void
    {
        $this->mrToken = $mrToken;
        $this->medicalRecord = MedicalRecord::where('token', $mrToken)->firstOrFail();

        $this->form->fill([]); // alta nueva
    }

    protected function getFormStatePath(): string
    {
        return 'data';
    }

    /** Define el formulario (tu schema adaptado) */
    public function form(FilamentSchema $schema): FilamentSchema
    {
        return $schema
            ->schema([
                // Estado general (sin exponer medical_record_id)
                /*Select::make('status')
                    ->label('Estatus')
                    ->options([
                        'open'    => 'Abierto',
                        'closed'  => 'Cerrado',
                        'pending' => 'Pendiente',
                    ])
                    ->default('open')
                    ->required(),

                Textarea::make('general_notes')
                    ->label('Notas generales')
                    ->rows(4)
                    ->maxLength(2000),

                Section::make('Datos personales y contacto')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('first_name')->label('Nombre')->required()->maxLength(120),
                            TextInput::make('middle_name')->label('Segundo nombre')->maxLength(120),
                            TextInput::make('last_name_father')->label('Apellido paterno')->required()->maxLength(120),
                            TextInput::make('last_name_mother')->label('Apellido materno')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            DatePicker::make('dob')->label('Fecha de nacimiento')->native(false),
                            TextInput::make('age_text')->label('Edad (texto)')->maxLength(50),
                            Select::make('sex')->label('Sexo')->options([
                                'Female' => 'Femenino',
                                'Male'   => 'Masculino',
                                'Other'  => 'Otro',
                            ]),
                            TextInput::make('blood_type')->label('Tipo de sangre')->maxLength(30),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('address')->label('Dirección')->columnSpan(2)->maxLength(255),
                            TextInput::make('phone')->label('Teléfono')->tel()->maxLength(30),
                            TextInput::make('birthplace')->label('Lugar de nacimiento')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('emergency_contact_name')->label('Contacto de emergencia')->maxLength(190),
                            TextInput::make('emergency_contact_phone')->label('Tel. de emergencia')->tel()->maxLength(30),
                            Select::make('marital_status')->label('Estado civil')->options([
                                'Soltera / soltero' => 'Soltera / soltero',
                                'Casada / casado'   => 'Casada / casado',
                                'Other'             => 'Otro',
                            ]),
                            TextInput::make('education_level')->label('Escolaridad')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('religion')->label('Religión')->maxLength(120),
                            TextInput::make('home_pets')->label('Mascotas en casa')->helperText('Ej.: Perro, Gato'),
                            Toggle::make('vaccination_complete')->label('Esquema de vacunación completo')->inline(false),
                            TextInput::make('email')->label('Correo electrónico')->email()->maxLength(190),
                        ]),
                    ])->collapsible(),*/

                Section::make('Motivo de consulta y dolor')
                    ->schema([
                        Textarea::make('chief_complaint')->label('Motivo de consulta')->rows(3)->required(),
                        Grid::make(4)->schema([
                            Select::make('treatment_goal')->label('Objetivo del tratamiento')->options([
                                'Diagnosis and evaluation' => 'Diagnóstico y evaluación',
                                'Pain relief'              => 'Control del dolor',
                                'Rehabilitation'           => 'Rehabilitación',
                                'Performance'              => 'Rendimiento',
                                'Other'                    => 'Otro',
                            ]),
                            TextInput::make('pain_intensity_min')->label('Dolor mínimo (0–10)')->numeric()->minValue(0)->maxValue(10),
                            TextInput::make('pain_intensity_max')->label('Dolor máximo (0–10)')->numeric()->minValue(0)->maxValue(10),
                            TextInput::make('pain_duration')->label('Duración del dolor')->maxLength(120)->helperText('Ej.: > 1 año'),
                        ]),
                        Textarea::make('pain_onset_how')->label('Inicio del dolor (¿cómo?)')->rows(2),
                        TagsInput::make('pain_areas')->label('Zonas de dolor')->placeholder('Ej.: Rodilla, Espalda'),
                        TagsInput::make('pain_triggers')->label('Desencadenantes')->placeholder('Ej.: Doblarse, Correr'),
                        TagsInput::make('pain_relievers')->label('Aliviantes')->placeholder('Ej.: Reposo, Estiramientos'),
                        KeyValue::make('pain_qualities')->keyLabel('Cualidad')->valueLabel('Valor')->helperText('Ej.: entumecimiento => true/false'),
                        KeyValue::make('treatments_tried')->keyLabel('Tratamiento')->valueLabel('Resultado')->helperText('Ej.: Fisioterapia => Positivo'),
                    ])->collapsible(),

                Section::make('Antecedentes familiares y personales')
                    ->schema([
                        Toggle::make('family_chronic_diseases')->label('¿Enfermedades crónicas en familia?')->inline(false),
                        KeyValue::make('family_diseases_details')->keyLabel('Familiar')->valueLabel('Enfermedad(es)'),
                        TagsInput::make('childhood_diseases')->label('Enfermedades de infancia')->placeholder('Ej.: Varicela'),
                        TextInput::make('current_diseases')->label('Padecimientos actuales')->maxLength(190),
                    ])->collapsible(),

                Section::make('Hospitalizaciones, cirugías y lesiones')
                    ->schema([
                        Toggle::make('ever_hospitalized')->label('¿Ha sido hospitalizado(a)?')->inline(false),
                        Grid::make(3)->schema([
                            Textarea::make('hospitalization_cause')->label('Causa')->rows(2),
                            DatePicker::make('hospitalization_date')->label('Fecha')->native(false),
                            Textarea::make('hospitalization_complications')->label('Complicaciones')->rows(2),
                        ]),
                        Textarea::make('hospitalizations_more')->label('Otras hospitalizaciones')->rows(2),

                        Toggle::make('ever_surgery')->label('¿Ha tenido cirugías?')->inline(false),
                        Grid::make(4)->schema([
                            TextInput::make('surgeries_count')->label('Número de cirugías')->numeric()->minValue(0)->maxValue(50),
                            TextInput::make('last_surgery_reason')->label('Motivo última cirugía')->maxLength(190),
                            TextInput::make('last_surgery_name')->label('Nombre última cirugía')->maxLength(190),
                            DatePicker::make('last_surgery_date')->label('Fecha última cirugía')->native(false),
                        ]),
                        Textarea::make('surgery_complications')->label('Complicaciones quirúrgicas')->rows(2),
                        Textarea::make('surgeries_more')->label('Otras cirugías')->rows(2),

                        Toggle::make('previous_injuries')->label('¿Lesiones previas?')->inline(false),
                        Grid::make(3)->schema([
                            Textarea::make('last_injury_description')->label('Última lesión (descripción)')->rows(2),
                            DatePicker::make('last_injury_date')->label('Fecha')->native(false),
                            Textarea::make('last_injury_treatment')->label('Tratamiento')->rows(2),
                        ]),
                        Textarea::make('last_injury_complications')->label('Complicaciones')->rows(2),
                        Textarea::make('injuries_more')->label('Otras lesiones')->rows(2),
                    ])->collapsible(),

                Section::make('Alergias y medicación')
                    ->schema([
                        Toggle::make('has_allergies')->label('¿Tiene alergias?')->inline(false),
                        Textarea::make('allergy_substances')->label('Sustancias / alergias')->rows(2),
                        Toggle::make('has_current_medication')->label('¿Toma medicamentos actualmente?')->inline(false),
                        Textarea::make('current_medications')->label('Medicamentos actuales')->rows(3)
                            ->helperText('Formato sugerido: fármaco, dosis, horario, días'),
                    ])->collapsible(),

                Section::make('Revisión por sistemas (último mes)')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('ros_senses')->label('Sentidos')->options(self::rosOptions()),
                            Select::make('ros_neurologic')->label('Neurológico')->options(self::rosOptions()),
                            Select::make('ros_cardiovascular')->label('Cardiovascular')->options(self::rosOptions()),
                            Select::make('ros_respiratory')->label('Respiratorio')->options(self::rosOptions()),
                            Select::make('ros_digestive')->label('Digestivo')->options(self::rosOptions()),
                            Select::make('ros_urinary')->label('Urinario')->options(self::rosOptions()),
                            Select::make('ros_endocrine')->label('Endócrino')->options(self::rosOptions()),
                            Select::make('ros_hematologic')->label('Hematológico')->options(self::rosOptions()),
                            Select::make('ros_skin')->label('Piel')->options(self::rosOptions()),
                        ]),
                    ])->collapsible(),

                Section::make('Gineco-obstétrico (opcional)')
                    ->schema([
                        Toggle::make('gyn_ob_enabled')->label('Activar sección Gineco-Obstétrica')->inline(false),
                        Grid::make(4)->schema([
                            DatePicker::make('menarche_date')->label('Menarquia')->native(false),
                            Toggle::make('has_menses')->label('¿Menstrúa actualmente?')->inline(false),
                            DatePicker::make('lmp_date')->label('FUM')->native(false),
                            TextInput::make('gyn_phase_or_dx')->label('Fase / Dx')->maxLength(190),
                        ]),
                        Textarea::make('gyn_prescribed_meds')->label('Medicamentos prescritos')->rows(2),
                        Grid::make(4)->schema([
                            Toggle::make('ever_pregnant')->label('¿Ha estado embarazada?')->inline(false),
                            TextInput::make('pregnancies_count')->label('Embarazos')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('deliveries_count')->label('Partos')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('cesareans_count')->label('Cesáreas')->numeric()->minValue(0)->maxValue(20),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('abortions_count')->label('Abortos')->numeric()->minValue(0)->maxValue(20),
                            Select::make('cycle_regular')->label('Ciclo')->options([
                                'Regular'   => 'Regular',
                                'Irregular' => 'Irregular',
                            ]),
                            TextInput::make('cycle_interval')->label('Intervalo')->maxLength(50)->helperText('Ej.: 28–30 días'),
                            TextInput::make('cycle_duration')->label('Duración')->maxLength(50)->helperText('Ej.: 3–5 días'),
                        ]),
                        Grid::make(4)->schema([
                            Toggle::make('dysmenorrhea')->label('Dismenorrea')->inline(false),
                            Toggle::make('uses_analgesics_in_menses')->label('Analgésicos en menstruación')->inline(false),
                            TextInput::make('contraception_method')->label('Método anticonceptivo')->maxLength(120),
                            Toggle::make('current_pregnancy')->label('Embarazo actual')->inline(false),
                        ]),
                    ])->collapsed(),

                Section::make('Nutrición y bebidas')
                    ->schema([
                        Grid::make(4)->schema([
                            Toggle::make('special_diet')->label('¿Dieta especial?')->inline(false),
                            TextInput::make('meals_per_day')->label('Comidas por día')->numeric()->minValue(0)->maxValue(10),
                            Select::make('cook_frequency')->label('Frecuencia de cocinar')->options(self::freqOptions()),
                            Select::make('eat_out_frequency')->label('Frecuencia de comer fuera')->options(self::freqOptions()),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('usual_breakfast')->label('Desayuno usual')->maxLength(190),
                            TextInput::make('usual_lunch')->label('Comida usual')->maxLength(190),
                            TextInput::make('usual_dinner')->label('Cena usual')->maxLength(190),
                        ]),
                        Textarea::make('supplements')->label('Suplementos')->rows(2),
                        KeyValue::make('daily_beverages')->label('Bebidas diarias')->keyLabel('Bebida')->valueLabel('Cantidad')
                            ->helperText('Ej.: agua => 500–1000 ml'),
                        Grid::make(3)->schema([
                            TextInput::make('coffee_cups_per_day')->label('Tazas de café/día')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('tea_cups_per_day')->label('Tazas de té/día')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('urine_color_scale')->label('Escala color orina (1–8)')->numeric()->minValue(1)->maxValue(8),
                        ]),
                    ])->collapsible(),

                Section::make('Ocupación y carga diaria')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('activity_status')->label('Actividad principal')->helperText('Ej.: Estudia, Trabaja')->maxLength(120),
                            TextInput::make('occupation_title')->label('Ocupación')->maxLength(120),
                            TextInput::make('activity_time_text')->label('Tiempo en la actividad')->maxLength(120),
                            TextInput::make('perceived_stress_score')->label('Estrés percibido (0–10)')->numeric()->minValue(0)->maxValue(10),
                        ]),
                        TextInput::make('physical_effort_score')->label('Esfuerzo físico (0–10)')->numeric()->minValue(0)->maxValue(10),
                        Grid::make(4)->schema([
                            TextInput::make('hours_sleep_inactivity')->label('Horas: sueño/inactividad')->maxLength(20),
                            TextInput::make('hours_work_study')->label('Horas: trabajo/estudio')->maxLength(20),
                            TextInput::make('hours_hobbies_social')->label('Horas: hobbies/social')->maxLength(20),
                            TextInput::make('hours_training')->label('Horas: entrenamiento')->maxLength(20),
                        ]),
                    ])->collapsible(),

                Section::make('Actividad física y deporte')
                    ->schema([
                        Toggle::make('is_physically_active')->label('¿Es físicamente activo(a)?')->inline(false),
                        Grid::make(4)->schema([
                            Select::make('dominant_hand')->label('Mano dominante')->options([
                                'Right' => 'Derecha', 'Left' => 'Izquierda', 'Ambidextrous' => 'Ambidiestra',
                            ]),
                            Select::make('dominant_foot')->label('Pie dominante')->options([
                                'Right' => 'Derecho', 'Left' => 'Izquierdo', 'Both' => 'Ambos',
                            ]),
                            TextInput::make('current_sport')->label('Deporte actual')->maxLength(120),
                            TextInput::make('practice_time_years')->label('Tiempo practicando (años)')->maxLength(50),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('training_days_per_week')->label('Días de entrenamiento/sem')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('training_hours_per_day')->label('Horas de entrenamiento/día')->maxLength(50),
                            TextInput::make('sport_goal')->label('Objetivo deportivo')->maxLength(120),
                            TextInput::make('other_sports')->label('Otros deportes')->maxLength(190),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('days_vigorous')->label('Días vigorosa/sem')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_vigorous_per_day')->label('Min vigorosa/día')->numeric()->minValue(0)->maxValue(600),
                            TextInput::make('days_moderate')->label('Días moderada/sem')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_moderate_per_day')->label('Min moderada/día')->numeric()->minValue(0)->maxValue(600),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('days_walk_10min')->label('Días con caminata ≥10m')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_walk_per_day')->label('Min de caminata/día')->numeric()->minValue(0)->maxValue(600),
                            TextInput::make('sitting_hours_per_workday')->label('Horas sentado/día laboral')->numeric()->minValue(0)->maxValue(24),
                        ]),
                    ])->collapsible(),

                Section::make('Psicología y sueño (opcional)')
                    ->schema([
                        Toggle::make('psychology_enabled')->label('Activar sección de psicología')->inline(false),
                        KeyValue::make('anxiety_scale')->label('Escala de ansiedad')->keyLabel('Ítem')->valueLabel('Puntaje'),
                        KeyValue::make('perceived_stress_scale')->label('Estrés percibido')->keyLabel('Ítem')->valueLabel('Puntaje'),
                        KeyValue::make('phq9')->label('PHQ-9')->keyLabel('Ítem')->valueLabel('Puntaje'),

                        Toggle::make('sleep_survey_enabled')->label('Activar encuesta de sueño')->inline(false),
                        Grid::make(4)->schema([
                            TextInput::make('sleep_usual_bedtime')->label('Hora a dormir (usual)')->datalist(['22:00','23:00','00:00']),
                            TextInput::make('sleep_latency_minutes')->label('Latencia de sueño (min)')->numeric()->minValue(0)->maxValue(240),
                            TextInput::make('sleep_usual_waketime')->label('Hora de despertar (usual)')->datalist(['06:00','07:00','08:00']),
                            TextInput::make('sleep_hours_per_night')->label('Horas de sueño/noche')->numeric()->minValue(0)->maxValue(24),
                        ]),
                        KeyValue::make('sleep_problems')->label('Problemas de sueño')->keyLabel('Problema')->valueLabel('Frecuencia'),
                        Select::make('sleep_quality')->label('Calidad de sueño')->options(self::freqOptions()),
                        Select::make('sleep_meds_frequency')->label('Frecuencia de medicación para dormir')->options(self::freqOptions()),
                        Select::make('daytime_sleepiness_frequency')->label('Somnolencia diurna')->options(self::freqOptions()),
                        Select::make('daytime_low_motivation')->label('Baja motivación diurna')->options(self::freqOptions()),
                        TextInput::make('sleep_partner')->label('Duerme con pareja')->maxLength(120),
                        KeyValue::make('sleep_partner_observations')->label('Observaciones de la pareja')->keyLabel('Obs')->valueLabel('Frecuencia'),
                    ])->collapsed(),

                Section::make('Consentimiento y percepción semanal')
                    ->schema([
                        Toggle::make('consent_accepted')->label('Acepto el consentimiento informado')->inline(false),
                        Textarea::make('consent_text')->label('Texto de consentimiento')->rows(3),
                        Grid::make(4)->schema([
                            TextInput::make('weekly_sleep_score')->label('Sueño (1–7)')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_stress_score')->label('Estrés (1–7)')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_fatigue_score')->label('Fatiga (1–7)')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_muscle_pain_score')->label('Dolor muscular (1–7)')->numeric()->minValue(1)->maxValue(7),
                        ]),
                    ])->collapsible()->collapsed(),
            ])
            ->columns(1);
    }

    /** Submit: crea ClinicalHistory vinculado al expediente actual y redirige */
    public function submit(): \Symfony\Component\HttpFoundation\Response
    {
        $payload = $this->form->getState();

        // vínculo forzado al expediente actual
        $payload['medical_record_id'] = $this->medicalRecord->id;

        // default de estatus si no viene
        $payload['status'] = $payload['status'] ?? 'open';

        ClinicalHistory::create($payload);

        // opcional: limpiar si se queda en la página
        $this->form->fill([]);

        // Redirigir a página final
        return redirect()->route('public.thankyou');
    }

    /** Opciones para revisión por sistemas */
    protected static function rosOptions(): array
    {
        return [
            'Ninguno'   => 'Ninguno',
            'Leve'      => 'Leve',
            'Moderado'  => 'Moderado',
            'Severo'    => 'Severo',
            'Ninguna'   => 'Ninguna',
        ];
    }

    /** Opciones de frecuencia genéricas */
    protected static function freqOptions(): array
    {
        return [
            'Nunca'     => 'Nunca',
            'Rara vez'  => 'Rara vez',
            'A veces'   => 'A veces',
            'A menudo'  => 'A menudo',
            'Siempre'   => 'Siempre',
        ];
    }

    public function render()
    {
        return view('livewire.public-clinical-history-form');
    }
}
