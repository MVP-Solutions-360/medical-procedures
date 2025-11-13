<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureMetadata extends Model
{
    protected $fillable = [
        'procedure_id',
        'key',
        'value',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
