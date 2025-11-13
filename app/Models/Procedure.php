<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'category',
        'summary',
        'description',
        'anesthesia',
        'surgery_time_min',
        'surgery_time_max',
        'hospitalization',
        'initial_recovery_weeks',
        'final_results_weeks',
        'risk_level',
        'is_active',
    ];

    // --- Relaciones ---
    public function sections()
    {
        return $this->hasMany(ProcedureSection::class)->orderBy('order');
    }

    public function techniques()
    {
        return $this->hasMany(ProcedureTechnique::class)->orderBy('order');
    }

    public function indications()
    {
        return $this->hasMany(ProcedureIndication::class)->orderBy('order');
    }

    public function preop()
    {
        return $this->hasMany(ProcedurePreop::class)->orderBy('order');
    }

    public function postop()
    {
        return $this->hasMany(ProcedurePostop::class)->orderBy('order');
    }

    public function extras()
    {
        return $this->hasMany(ProcedureExtra::class)->orderBy('order');
    }

    public function risks()
    {
        return $this->hasMany(ProcedureRisk::class)->orderBy('order');
    }

    public function images()
    {
        return $this->hasMany(ProcedureImage::class)->orderBy('order');
    }

    public function metadata()
    {
        return $this->hasMany(ProcedureMetadata::class);
    }
}
