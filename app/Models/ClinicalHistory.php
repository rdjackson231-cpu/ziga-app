<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClinicalHistory extends Model
{
    //
    protected $table = 'clinical_histories';

    /*protected $fillable = [
        'patient_id',
        'status',
        'general_notes',
        //--------------------consultation reasons-------------------
        'consultation_reason',
        'consultation_objective',
        'syntomatology_zones',
        'pain_start_description',
        'max_pain',
        'min_pain',
        'pain_description',
        'triggers',
        'mitigating_factors',
        'start_date',
        'used_treatments',
        //---------------------
    ];*/

    protected $fillable = [
        'medical_record_id',
        'status',
        'general_notes',
        'submitted_at', 
        /*'email',
        'last_name_father','last_name_mother','first_name','middle_name','dob','age_text','sex','address','phone','blood_type',
        'emergency_contact_name','emergency_contact_phone',*/
        'chief_complaint','treatment_goal','pain_intensity_max','pain_intensity_min','pain_duration','pain_onset_how',
        'pain_areas','pain_triggers','pain_relievers','pain_qualities','treatments_tried',
        'birthplace','marital_status','education_level','religion','home_pets','vaccination_complete',
        'tobacco_use','cigarettes_per_day','years_smoking',
        'drug_use','drug_use_frequency','drug_substances',
        'alcohol_use','alcohol_frequency',
        'family_chronic_diseases','family_diseases_details','childhood_diseases',
        'current_diseases',
        'ever_hospitalized','hospitalization_cause','hospitalization_date','hospitalization_complications','hospitalizations_more',
        'ever_surgery','surgeries_count','last_surgery_reason','last_surgery_name','last_surgery_date','surgery_complications','surgeries_more',
        'previous_injuries','last_injury_description','last_injury_date','last_injury_treatment','last_injury_complications','injuries_more',
        'has_allergies','allergy_substances','has_current_medication','current_medications',
        'ros_senses','ros_neurologic','ros_cardiovascular','ros_respiratory','ros_digestive','ros_urinary','ros_endocrine','ros_hematologic','ros_skin',
        'gyn_ob_enabled','menarche_date','has_menses','lmp_date','gyn_phase_or_dx','gyn_prescribed_meds','ever_pregnant','cycle_regular','cycle_interval','cycle_duration','dysmenorrhea','uses_analgesics_in_menses','contraception_method','current_pregnancy','pregnancies_count','deliveries_count','cesareans_count','abortions_count',
        'special_diet','meals_per_day','cook_frequency','eat_out_frequency','usual_breakfast','usual_lunch','usual_dinner','supplements','daily_beverages','coffee_cups_per_day','tea_cups_per_day','urine_color_scale',
        'activity_status','occupation_title','activity_time_text','perceived_stress_score','physical_effort_score',
        'hours_sleep_inactivity','hours_work_study','hours_hobbies_social','hours_training',
        'is_physically_active','dominant_hand','dominant_foot','current_sport','practice_time_years','training_days_per_week','training_hours_per_day','sport_goal','other_sports',
        'days_vigorous','minutes_vigorous_per_day','days_moderate','minutes_moderate_per_day','days_walk_10min','minutes_walk_per_day','sitting_hours_per_workday',
        'psychology_enabled','anxiety_scale','perceived_stress_scale','phq9',
        'sleep_survey_enabled','sleep_usual_bedtime','sleep_latency_minutes','sleep_usual_waketime','sleep_hours_per_night','sleep_problems','sleep_quality','sleep_meds_frequency','daytime_sleepiness_frequency','daytime_low_motivation','sleep_partner','sleep_partner_observations',
        'consent_text','consent_accepted',
        'weekly_sleep_score','weekly_stress_score','weekly_fatigue_score','weekly_muscle_pain_score',
        'external_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'dob' => 'date',
        'hospitalization_date' => 'date',
        'last_surgery_date' => 'date',
        'last_injury_date' => 'date',
        'menarche_date' => 'date',
        'lmp_date' => 'date',

        // JSON / arrays
        'pain_areas' => 'array',
        'pain_triggers' => 'array',
        'pain_relievers' => 'array',
        'pain_qualities' => 'array',
        'treatments_tried' => 'array',
        'family_diseases_details' => 'array',
        'childhood_diseases' => 'array',
        'daily_beverages' => 'array',
        'anxiety_scale' => 'array',
        'perceived_stress_scale' => 'array',
        'phq9' => 'array',
        'sleep_problems' => 'array',
        'sleep_partner_observations' => 'array',

        // Booleans
        'vaccination_complete' => 'boolean',
        'tobacco_use' => 'boolean',
        'drug_use' => 'boolean',
        'alcohol_use' => 'boolean',
        'ever_hospitalized' => 'boolean',
        'ever_surgery' => 'boolean',
        'previous_injuries' => 'boolean',
        'has_allergies' => 'boolean',
        'has_current_medication' => 'boolean',
        'gyn_ob_enabled' => 'boolean',
        'ever_pregnant' => 'boolean',
        'current_pregnancy' => 'boolean',
        'special_diet' => 'boolean',
        'is_physically_active' => 'boolean',
        'psychology_enabled' => 'boolean',
        'sleep_survey_enabled' => 'boolean',
        'consent_accepted' => 'boolean',
        'has_menses' => 'boolean',
        'dysmenorrhea' => 'boolean',
        'uses_analgesics_in_menses' => 'boolean',
    ];

    /*
     * Relación con Paciente
     
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }*/

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }

}