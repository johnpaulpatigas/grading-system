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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            if (!$student->student_id) {
                $year = now()->format('Y');
                $latest = self::where('student_id', 'LIKE', "STU-$year-%")->orderBy('student_id', 'desc')->first();
                $sequence = $latest ? (int) substr($latest->student_id, -4) + 1 : 1;
                $student->student_id = "STU-$year-" . str_pad($sequence, 4, '0', STR_PAD_LEFT);
            }
        });
    }

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
