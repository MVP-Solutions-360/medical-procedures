<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcedureSection extends Model
{
    protected $fillable = [
        'procedure_id',
        'title',
        'order',
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class);
    }

    public function contents()
    {
        return $this->hasMany(ProcedureSectionContent::class, 'section_id')->orderBy('order');
    }
}
