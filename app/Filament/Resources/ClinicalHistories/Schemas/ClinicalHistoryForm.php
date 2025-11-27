<?php

namespace App\Filament\Resources\ClinicalHistories\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

use Filament\Forms\Form;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\KeyValue;

class ClinicalHistoryForm
{

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
Forms\Components\Select::make('medical_record_id')
    ->label('Medical Record')
    ->searchable()
    ->getSearchResultsUsing(fn (?string $search) => \App\Models\MedicalRecord::with('patient')
        ->when($search, fn($q) => $q->where('code', 'ILIKE', "%{$search}%")
            ->orWhereHas('patient', fn($q2) => $q2->where('first_name', 'ILIKE', "%{$search}%")
                ->orWhere('last_name', 'ILIKE', "%{$search}%")
            )
        )
        ->orderBy('code')
        ->limit(50)
        ->get()
        ->mapWithKeys(fn($r) => [
            $r->id => trim("{$r->code}" . ($r->patient?->first_name ? " — {$r->patient->first_name} {$r->patient->last_name}" : ''))
        ])->toArray()
    )
    // <-- ADD this so Filament can validate selected value
    ->getOptionLabelUsing(fn ($value) => optional(\App\Models\MedicalRecord::with('patient')->find($value))
        ? (function($r){ return trim("{$r->code}" . ($r->patient?->first_name ? " — {$r->patient->first_name} {$r->patient->last_name}" : '')); } )(
            \App\Models\MedicalRecord::with('patient')->find($value)
        )
        : (string) $value
    )
    ->helperText('Buscar por código o por nombre del paciente')
    ->required(),

                /*Forms\Components\Select::make('status')
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'closed' => 'Closed',
                    'pending' => 'Pending',
                ])
                ->required(),

                Forms\Components\Textarea::make('general_notes')
                ->label('General Notes')
                ->rows(5)
                ->maxLength(2000),*/

                Section::make('Submission & Link')
                    ->schema([
                        DatePicker::make('submitted_at')
                            ->label('Submitted at')
                            ->native(false),
                        TextInput::make('email')->email()->maxLength(190),
                        TextInput::make('external_id')->label('External ID')->maxLength(190),
                        //TextInput::make('medical_record_id')
                            //->numeric()
                            //->label('Medical Record ID')
                            //->helperText('Optional one-to-one link to medical_records'),
                    ])->columns(4),

                /*Section::make('Personal Info & Contact')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('first_name')->required()->maxLength(120),
                            TextInput::make('middle_name')->maxLength(120),
                            TextInput::make('last_name_father')->label('Last name (father)')->required()->maxLength(120),
                            TextInput::make('last_name_mother')->label('Last name (mother)')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            DatePicker::make('dob')->label('Date of birth')->native(false),
                            TextInput::make('age_text')->label('Age (raw)')->maxLength(50),
                            Select::make('sex')->options([
                                'Female' => 'Female',
                                'Male' => 'Male',
                                'Other' => 'Other',
                            ]),
                            TextInput::make('blood_type')->maxLength(30),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('address')->columnSpan(2)->maxLength(255),
                            TextInput::make('phone')->tel()->maxLength(30),
                            TextInput::make('birthplace')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('emergency_contact_name')->label('Emergency contact')->maxLength(190),
                            TextInput::make('emergency_contact_phone')->label('Emergency phone')->tel()->maxLength(30),
                            Select::make('marital_status')->options([
                                'Soltera / soltero' => 'Single',
                                'Casada / casado' => 'Married',
                                'Other' => 'Other',
                            ]),
                            TextInput::make('education_level')->maxLength(120),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('religion')->maxLength(120),
                            TextInput::make('home_pets')->label('Home pets')->helperText('e.g., Perro, Gato'),
                            Toggle::make('vaccination_complete')->label('Vaccination complete')->inline(false),
                        ]),
                    ])->collapsible(),*/

                Section::make('Chief Complaint & Pain')
                    ->schema([
                        Textarea::make('chief_complaint')->rows(2)->columnSpanFull(),
                        Grid::make(4)->schema([
                            Select::make('treatment_goal')->options([
                                'Diagnosis and evaluation' => 'Diagnosis and evaluation',
                                'Pain relief' => 'Pain relief',
                                'Rehabilitation' => 'Rehabilitation',
                                'Performance' => 'Performance',
                                'Other' => 'Other',
                            ]),
                            TextInput::make('pain_intensity_min')->label('Pain min (0-10)')
                                ->numeric()->minValue(0)->maxValue(10),
                            TextInput::make('pain_intensity_max')->label('Pain max (0-10)')
                                ->numeric()->minValue(0)->maxValue(10),
                            TextInput::make('pain_duration')->maxLength(120)->helperText('e.g., >1 año'),
                        ]),
                        Textarea::make('pain_onset_how')->label('Onset (how)')->rows(2),
                        TagsInput::make('pain_areas')->label('Pain areas')->placeholder('e.g., Rodilla'),
                        TagsInput::make('pain_triggers')->label('Triggers')->placeholder('e.g., Doblarse'),
                        TagsInput::make('pain_relievers')->label('Relievers')->placeholder('e.g., Estiramientos'),
                        KeyValue::make('pain_qualities')
                            ->keyLabel('Quality')->valueLabel('Value')
                            ->helperText('e.g., numbness => true/false'),
                        KeyValue::make('treatments_tried')
                            ->keyLabel('Treatment')->valueLabel('Outcome')
                            ->helperText('Outcome e.g., Positivo / Negativo'),
                    ])->collapsible(),

                Section::make('Family & Personal History')
                    ->schema([
                        Toggle::make('family_chronic_diseases')->inline(false)->label('Family chronic diseases?'),
                        KeyValue::make('family_diseases_details')
                            ->keyLabel('Relative')->valueLabel('Disease(s)'),
                        TagsInput::make('childhood_diseases')->helperText('e.g., Varicela'),
                        TextInput::make('current_diseases')->maxLength(190),
                    ])->collapsible(),

                Section::make('Hospitalizations & Surgeries & Injuries')
                    ->schema([
                        // Hospitalizations
                        Toggle::make('ever_hospitalized')->label('Ever hospitalized?')->inline(false),
                        Grid::make(3)->schema([
                            Textarea::make('hospitalization_cause')->rows(2),
                            DatePicker::make('hospitalization_date')->native(false),
                            Textarea::make('hospitalization_complications')->rows(2),
                        ]),
                        Textarea::make('hospitalizations_more')->rows(2),

                        // Surgeries
                        Toggle::make('ever_surgery')->label('Ever surgery?')->inline(false),
                        Grid::make(4)->schema([
                            TextInput::make('surgeries_count')->numeric()->minValue(0)->maxValue(50),
                            TextInput::make('last_surgery_reason')->maxLength(190),
                            TextInput::make('last_surgery_name')->maxLength(190),
                            DatePicker::make('last_surgery_date')->native(false),
                        ]),
                        Textarea::make('surgery_complications')->rows(2),
                        Textarea::make('surgeries_more')->rows(2),

                        // Injuries
                        Toggle::make('previous_injuries')->label('Previous injuries?')->inline(false),
                        Grid::make(3)->schema([
                            Textarea::make('last_injury_description')->rows(2),
                            DatePicker::make('last_injury_date')->native(false),
                            Textarea::make('last_injury_treatment')->rows(2),
                        ]),
                        Textarea::make('last_injury_complications')->rows(2),
                        Textarea::make('injuries_more')->rows(2),
                    ])->collapsible(),

                Section::make('Allergies & Medication')
                    ->schema([
                        Toggle::make('has_allergies')->inline(false),
                        Textarea::make('allergy_substances')->rows(2),
                        Toggle::make('has_current_medication')->inline(false),
                        Textarea::make('current_medications')->rows(3)
                            ->helperText('Format: drug, dose, schedule, days'),
                    ])->collapsible(),

                Section::make('Review of Systems (last month)')
                    ->schema([
                        Grid::make(3)->schema([
                            Select::make('ros_senses')->options(self::rosOptions()),
                            Select::make('ros_neurologic')->options(self::rosOptions()),
                            Select::make('ros_cardiovascular')->options(self::rosOptions()),
                            Select::make('ros_respiratory')->options(self::rosOptions()),
                            Select::make('ros_digestive')->options(self::rosOptions()),
                            Select::make('ros_urinary')->options(self::rosOptions()),
                            Select::make('ros_endocrine')->options(self::rosOptions()),
                            Select::make('ros_hematologic')->options(self::rosOptions()),
                            Select::make('ros_skin')->options(self::rosOptions()),
                        ]),
                    ])->collapsible(),

                Section::make('Gyn-Ob (optional)')
                    ->schema([
                        Toggle::make('gyn_ob_enabled')->inline(false),
                        Grid::make(4)->schema([
                            DatePicker::make('menarche_date')->native(false),
                            Toggle::make('has_menses')->inline(false),
                            DatePicker::make('lmp_date')->label('LMP')->native(false),
                            TextInput::make('gyn_phase_or_dx')->maxLength(190),
                        ]),
                        Textarea::make('gyn_prescribed_meds')->rows(2),
                        Grid::make(4)->schema([
                            Toggle::make('ever_pregnant')->inline(false),
                            TextInput::make('pregnancies_count')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('deliveries_count')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('cesareans_count')->numeric()->minValue(0)->maxValue(20),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('abortions_count')->numeric()->minValue(0)->maxValue(20),
                            Select::make('cycle_regular')->options([
                                'Regular' => 'Regular',
                                'Irregular' => 'Irregular',
                            ]),
                            TextInput::make('cycle_interval')->maxLength(50)->helperText('e.g., 28-30 days'),
                            TextInput::make('cycle_duration')->maxLength(50)->helperText('e.g., 3-5 days'),
                        ]),
                        Grid::make(4)->schema([
                            Toggle::make('dysmenorrhea')->inline(false)->label('Period pain'),
                            Toggle::make('uses_analgesics_in_menses')->inline(false)->label('Analgesics during menses'),
                            TextInput::make('contraception_method')->maxLength(120),
                            Toggle::make('current_pregnancy')->inline(false),
                        ]),
                    ])
                    ->collapsed(),
                    //->visible(fn ($get) => (bool) $get('gyn_ob_enabled')),
                    
                Section::make('Nutrition & Beverages')
                    ->schema([
                        Grid::make(4)->schema([
                            Toggle::make('special_diet')->inline(false),
                            TextInput::make('meals_per_day')->numeric()->minValue(0)->maxValue(10),
                            Select::make('cook_frequency')->options(self::freqOptions()),
                            Select::make('eat_out_frequency')->options(self::freqOptions()),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('usual_breakfast')->maxLength(190),
                            TextInput::make('usual_lunch')->maxLength(190),
                            TextInput::make('usual_dinner')->maxLength(190),
                        ]),
                        Textarea::make('supplements')->rows(2),
                        KeyValue::make('daily_beverages')
                            ->keyLabel('Beverage')->valueLabel('Qty')
                            ->helperText('e.g., water => 500-1000ml, milk => 0-500ml'),
                        Grid::make(3)->schema([
                            TextInput::make('coffee_cups_per_day')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('tea_cups_per_day')->numeric()->minValue(0)->maxValue(20),
                            TextInput::make('urine_color_scale')->numeric()->minValue(1)->maxValue(8),
                        ]),
                    ])->collapsible(),

                Section::make('Occupation & Daily Load')
                    ->schema([
                        Grid::make(4)->schema([
                            TextInput::make('activity_status')->maxLength(120)->helperText('e.g., Estudia'),
                            TextInput::make('occupation_title')->maxLength(120),
                            TextInput::make('activity_time_text')->label('Activity time (raw)')->maxLength(120),
                            TextInput::make('perceived_stress_score')->numeric()->minValue(0)->maxValue(10),
                        ]),
                        TextInput::make('physical_effort_score')->numeric()->minValue(0)->maxValue(10),
                        Grid::make(4)->schema([
                            TextInput::make('hours_sleep_inactivity')->label('Hours: sleep/inactivity')->maxLength(20),
                            TextInput::make('hours_work_study')->label('Hours: work/study')->maxLength(20),
                            TextInput::make('hours_hobbies_social')->label('Hours: hobbies/social')->maxLength(20),
                            TextInput::make('hours_training')->label('Hours: training')->maxLength(20),
                        ]),
                    ])->collapsible(),

                Section::make('Physical Activity & Sport')
                    ->schema([
                        Toggle::make('is_physically_active')->inline(false),
                        Grid::make(4)->schema([
                            Select::make('dominant_hand')->options([
                                'Right' => 'Right', 'Left' => 'Left', 'Ambidextrous' => 'Ambidextrous',
                            ]),
                            Select::make('dominant_foot')->options([
                                'Right' => 'Right', 'Left' => 'Left', 'Both' => 'Both',
                            ]),
                            TextInput::make('current_sport')->maxLength(120),
                            TextInput::make('practice_time_years')->maxLength(50)->helperText('e.g., 4 años'),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('training_days_per_week')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('training_hours_per_day')->maxLength(50),
                            TextInput::make('sport_goal')->maxLength(120),
                            TextInput::make('other_sports')->maxLength(190),
                        ]),
                        Grid::make(4)->schema([
                            TextInput::make('days_vigorous')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_vigorous_per_day')->numeric()->minValue(0)->maxValue(600),
                            TextInput::make('days_moderate')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_moderate_per_day')->numeric()->minValue(0)->maxValue(600),
                        ]),
                        Grid::make(3)->schema([
                            TextInput::make('days_walk_10min')->numeric()->minValue(0)->maxValue(7),
                            TextInput::make('minutes_walk_per_day')->numeric()->minValue(0)->maxValue(600),
                            TextInput::make('sitting_hours_per_workday')->numeric()->minValue(0)->maxValue(24),
                        ]),
                    ])->collapsible(),

                Section::make('Psychology & Sleep (optional)')
                    ->schema([
                        Toggle::make('psychology_enabled')->inline(false),
                        KeyValue::make('anxiety_scale')->keyLabel('Item')->valueLabel('Score'),
                        KeyValue::make('perceived_stress_scale')->keyLabel('Item')->valueLabel('Score'),
                        KeyValue::make('phq9')->keyLabel('Item')->valueLabel('Score'),

                        Toggle::make('sleep_survey_enabled')->inline(false),
                        Grid::make(4)->schema([
                            TextInput::make('sleep_usual_bedtime')->datalist(['22:00','23:00','00:00']),
                            TextInput::make('sleep_latency_minutes')->numeric()->minValue(0)->maxValue(240),
                            TextInput::make('sleep_usual_waketime')->datalist(['06:00','07:00','08:00']),
                            TextInput::make('sleep_hours_per_night')->numeric()->minValue(0)->maxValue(24),
                        ]),
                        KeyValue::make('sleep_problems')->keyLabel('Problem')->valueLabel('Freq'),
                        Select::make('sleep_quality')->options(self::freqOptions()),
                        Select::make('sleep_meds_frequency')->options(self::freqOptions()),
                        Select::make('daytime_sleepiness_frequency')->options(self::freqOptions()),
                        Select::make('daytime_low_motivation')->options(self::freqOptions()),
                        TextInput::make('sleep_partner')->maxLength(120),
                        KeyValue::make('sleep_partner_observations')
                            ->keyLabel('Observation')->valueLabel('Freq'),
                    ])->collapsed(),

                Section::make('Consent & Weekly Perception')
                    ->schema([
                        Toggle::make('consent_accepted')->inline(false),
                        Textarea::make('consent_text')->rows(3),
                        Grid::make(4)->schema([
                            TextInput::make('weekly_sleep_score')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_stress_score')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_fatigue_score')->numeric()->minValue(1)->maxValue(7),
                            TextInput::make('weekly_muscle_pain_score')->numeric()->minValue(1)->maxValue(7),
                        ]),
                    ])->collapsible()->collapsed(),
            ])
            ->columns(1);
    }



    /** Simple enumerations for selects */
    protected static function rosOptions(): array
    {
        return [
            'Ninguno' => 'None',
            'Leve'    => 'Mild',
            'Moderado'=> 'Moderate',
            'Severo'  => 'Severe',
            'Ninguna' => 'None', // para campos con femenino en el source
        ];
    }

    protected static function freqOptions(): array
    {
        return [
            'Nunca' => 'Never',
            'Rara vez' => 'Rarely',
            'A veces' => 'Sometimes',
            'A menudo' => 'Often',
            'Siempre' => 'Always',
        ];
    }
}
