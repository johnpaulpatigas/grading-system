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

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }

    public function prerequisites()
    {
        return $this->belongsToMany(Subject::class, 'subject_prerequisites', 'subject_id', 'prerequisite_id');
    }

    public function requiredFor()
    {
        return $this->belongsToMany(Subject::class, 'subject_prerequisites', 'prerequisite_id', 'subject_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
