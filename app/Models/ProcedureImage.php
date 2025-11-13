<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureImage extends Model
{
    protected $fillable = [
        'procedure_id',
        'url',
        'description',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
