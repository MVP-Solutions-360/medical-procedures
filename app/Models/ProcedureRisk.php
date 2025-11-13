<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureRisk extends Model
{
    protected $fillable = [
        'procedure_id',
        'risk',
        'description',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
