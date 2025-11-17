<?php

// database/migrations/2025_09_30_000001_create_historias_clinicas_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('clinical_histories', function (Blueprint $table) {
            $table->id();
            // 🔹 Solo referencia al expediente médico
            $table->foreignId('medical_record_id')
            ->constrained('medical_records')
            ->cascadeOnDelete();
            $table->text('status')->nullable();
            $table->text('general_notes')->nullable();
            // --- Metadatos del formulario ---
            $table->timestamp('submitted_at')->nullable();            // "Marca temporal"

            /* --- Datos personales ---
            $table->string('last_name_father')->nullable();          // Apellido Paterno  
            $table->string('last_name_mother')->nullable();          // Apellido Materno
            $table->string('first_name')->nullable();                // Primer Nombre
            $table->string('middle_name')->nullable();               // Segundo Nombre
            $table->date('dob')->nullable();                         // Fecha de nacimiento
            $table->string('age_text')->nullable();                  // "15 AÑOS" (texto libre)
            $table->enum('sex', ['Female','Male','Other'])->nullable();
            $table->string('address')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('blood_type')->nullable();*/

            // --- Contacto de emergencia ---
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();

            // --- Motivo de consulta / Dolor actual ---
            $table->string('chief_complaint')->nullable();               // Describe el motivo
            $table->enum('treatment_goal', ['Diagnosis and evaluation','Pain relief','Rehabilitation','Performance','Other'])->nullable();
            $table->tinyInteger('pain_intensity_max')->nullable();       // 0-10
            $table->tinyInteger('pain_intensity_min')->nullable();       // 0-10
            $table->string('pain_duration')->nullable();                 // "Hace más de 1 año"
            $table->text('pain_onset_how')->nullable();                  // "EN UN ENTRENAMIENTO DE TENIS"
            $table->json('pain_areas')->nullable();                      // ["RODILLA", ...]
            $table->json('pain_triggers')->nullable();                   // ["Doblarse", ...]
            $table->json('pain_relievers')->nullable();                  // ["Hacer estiramientos", ...]
            $table->json('pain_qualities')->nullable();                  // p.ej. {"numbness": false, ...}
            $table->json('treatments_tried')->nullable();                // mapa de tratamiento => "Negativo"/"Positivo"/...

            // --- Identidad y contexto ---
            $table->string('birthplace')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education_level')->nullable();
            $table->string('religion')->nullable();
            $table->string('home_pets')->nullable();                     // "Perro"
            $table->boolean('vaccination_complete')->nullable();

            // --- Hábitos / Consumos ---
            $table->boolean('tobacco_use')->nullable();
            $table->tinyInteger('cigarettes_per_day')->nullable();
            $table->tinyInteger('years_smoking')->nullable();

            $table->boolean('drug_use')->nullable();
            $table->string('drug_use_frequency')->nullable();
            $table->text('drug_substances')->nullable();

            $table->boolean('alcohol_use')->nullable();
            $table->string('alcohol_frequency')->nullable();

            // --- Antecedentes familiares y personales ---
            $table->boolean('family_chronic_diseases')->nullable();      // ¿Familiares con ECNT?
            $table->json('family_diseases_details')->nullable();         // {"father": "...", "mother": "...", ...}
            $table->json('childhood_diseases')->nullable();              // p.ej. ["Varicela"]

            $table->string('current_diseases')->nullable();              // "Ninguno"

            // --- Hospitalizaciones ---
            $table->boolean('ever_hospitalized')->nullable();
            $table->text('hospitalization_cause')->nullable();
            $table->date('hospitalization_date')->nullable();
            $table->text('hospitalization_complications')->nullable();
            $table->longText('hospitalizations_more')->nullable();

            // --- Cirugías ---
            $table->boolean('ever_surgery')->nullable();
            $table->tinyInteger('surgeries_count')->nullable();
            $table->string('last_surgery_reason')->nullable();
            $table->string('last_surgery_name')->nullable();
            $table->date('last_surgery_date')->nullable();
            $table->text('surgery_complications')->nullable();
            $table->longText('surgeries_more')->nullable();

            // --- Lesiones previas ---
            $table->boolean('previous_injuries')->nullable();
            $table->text('last_injury_description')->nullable();
            $table->date('last_injury_date')->nullable();
            $table->text('last_injury_treatment')->nullable();
            $table->text('last_injury_complications')->nullable();
            $table->longText('injuries_more')->nullable();

            // --- Alergias y medicación ---
            $table->boolean('has_allergies')->nullable();
            $table->text('allergy_substances')->nullable();
            $table->boolean('has_current_medication')->nullable();
            $table->longText('current_medications')->nullable();         // "Medicamento, dosis, horarios..."

            // --- Revisión por sistemas (último mes) ---
            $table->string('ros_senses')->nullable();
            $table->string('ros_neurologic')->nullable();
            $table->string('ros_cardiovascular')->nullable();
            $table->string('ros_respiratory')->nullable();
            $table->string('ros_digestive')->nullable();
            $table->string('ros_urinary')->nullable();
            $table->string('ros_endocrine')->nullable();
            $table->string('ros_hematologic')->nullable();
            $table->string('ros_skin')->nullable();

            // --- Gineco-obstétrico (opcional / menor de edad => quedará null) ---
            $table->boolean('gyn_ob_enabled')->nullable();
            $table->date('menarche_date')->nullable();
            $table->boolean('has_menses')->nullable();
            $table->date('lmp_date')->nullable();
            $table->string('gyn_phase_or_dx')->nullable();
            $table->text('gyn_prescribed_meds')->nullable();
            $table->boolean('ever_pregnant')->nullable();
            $table->string('cycle_regular')->nullable();
            $table->string('cycle_interval')->nullable();
            $table->string('cycle_duration')->nullable();
            $table->boolean('dysmenorrhea')->nullable();
            $table->boolean('uses_analgesics_in_menses')->nullable();
            $table->string('contraception_method')->nullable();
            $table->boolean('current_pregnancy')->nullable();
            $table->tinyInteger('pregnancies_count')->nullable();
            $table->tinyInteger('deliveries_count')->nullable();
            $table->tinyInteger('cesareans_count')->nullable();
            $table->tinyInteger('abortions_count')->nullable();

            // --- Nutrición y bebidas ---
            $table->boolean('special_diet')->nullable();
            $table->tinyInteger('meals_per_day')->nullable();
            $table->string('cook_frequency')->nullable();
            $table->string('eat_out_frequency')->nullable();
            $table->string('usual_breakfast')->nullable();
            $table->string('usual_lunch')->nullable();
            $table->string('usual_dinner')->nullable();
            $table->longText('supplements')->nullable();
            $table->json('daily_beverages')->nullable();  // {"water":"500-1000ml","milk":"0-500ml","juice":"none",...}
            $table->tinyInteger('coffee_cups_per_day')->nullable();
            $table->tinyInteger('tea_cups_per_day')->nullable();
            $table->tinyInteger('urine_color_scale')->nullable();

            // --- Ocupación y esfuerzo ---
            $table->string('activity_status')->nullable();               // "Estudia"
            $table->string('occupation_title')->nullable();              // "ESTUDIANTE"
            $table->string('activity_time_text')->nullable();            // "6 HORAS Y MEDIA"
            $table->tinyInteger('perceived_stress_score')->nullable();   // 0-10
            $table->tinyInteger('physical_effort_score')->nullable();    // 0-10

            // --- Distribución de tiempo diario ---
            $table->string('hours_sleep_inactivity')->nullable();        // "4H"
            $table->string('hours_work_study')->nullable();              // "6H"
            $table->string('hours_hobbies_social')->nullable();          // "3H"
            $table->string('hours_training')->nullable();                // "2H"

            // --- Actividad física / deporte ---
            $table->boolean('is_physically_active')->nullable();
            $table->enum('dominant_hand', ['Right','Left','Ambidextrous'])->nullable();
            $table->enum('dominant_foot', ['Right','Left','Both'])->nullable();
            $table->string('current_sport')->nullable();                 // "TENIS"
            $table->string('practice_time_years')->nullable();           // "4 AÑOS"
            $table->tinyInteger('training_days_per_week')->nullable();
            $table->string('training_hours_per_day')->nullable();        // "1 hr"
            $table->string('sport_goal')->nullable();                    // "Hobbie"
            $table->string('other_sports')->nullable();                  // "Voleibol, Yoga / Pilates"

            // --- Actividad física (IPAQ resumido) ---
            $table->tinyInteger('days_vigorous')->nullable();
            $table->integer('minutes_vigorous_per_day')->nullable();
            $table->tinyInteger('days_moderate')->nullable();
            $table->integer('minutes_moderate_per_day')->nullable();
            $table->tinyInteger('days_walk_10min')->nullable();
            $table->integer('minutes_walk_per_day')->nullable();
            $table->decimal('sitting_hours_per_workday', 4, 1)->nullable();

            // --- Psicología / Estrés (opcional) ---
            $table->boolean('psychology_enabled')->nullable();
            $table->json('anxiety_scale')->nullable();       // GAD-7 o similar, si lo llenan
            $table->json('perceived_stress_scale')->nullable(); // PSS
            $table->json('phq9')->nullable();                // Depresión

            // --- Sueño (opcional) ---
            $table->boolean('sleep_survey_enabled')->nullable();
            $table->string('sleep_usual_bedtime')->nullable();
            $table->integer('sleep_latency_minutes')->nullable();
            $table->string('sleep_usual_waketime')->nullable();
            $table->decimal('sleep_hours_per_night', 4, 1)->nullable();
            $table->json('sleep_problems')->nullable();
            $table->string('sleep_quality')->nullable();
            $table->string('sleep_meds_frequency')->nullable();
            $table->string('daytime_sleepiness_frequency')->nullable();
            $table->string('daytime_low_motivation')->nullable();
            $table->string('sleep_partner')->nullable();
            $table->json('sleep_partner_observations')->nullable();

            // --- Consentimiento / legal ---
            $table->longText('consent_text')->nullable();
            $table->boolean('consent_accepted')->nullable();

            // --- Percepción semanal (1 a 7) ---
            $table->tinyInteger('weekly_sleep_score')->nullable();
            $table->tinyInteger('weekly_stress_score')->nullable();
            $table->tinyInteger('weekly_fatigue_score')->nullable();
            $table->tinyInteger('weekly_muscle_pain_score')->nullable();

            // --- Campo libre para ID crudo del sheet, etc. ---
            $table->string('external_id')->nullable();

            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('clinical_histories');
    }
};