<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'subject_code',
        'description',
        'units',
    ];

    public function faculties()
    {
        return $this->belongsToMany(Faculty::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
