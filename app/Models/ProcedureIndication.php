<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureIndication extends Model
{
    protected $fillable = [
        'procedure_id',
        'type',
        'description',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
