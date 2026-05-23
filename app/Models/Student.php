<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'student_id',
        'course',
        'year_level',
        'section',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'enrollments');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
