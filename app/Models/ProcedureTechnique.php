<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureTechnique extends Model
{
    protected $fillable = [
        'procedure_id',
        'name',
        'description',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
