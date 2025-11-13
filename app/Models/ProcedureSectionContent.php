<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureSectionContent extends Model
{
    protected $fillable = [
        'section_id',
        'type',
        'content',
        'order',
    ];

    public function section()
    {
        return $this->belongsTo(ProcedureSection::class);
    }
}
