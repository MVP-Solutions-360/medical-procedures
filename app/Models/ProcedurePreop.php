<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedurePreop extends Model
{
    protected $fillable = [
        'procedure_id',
        'item',
        'category',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }
}
