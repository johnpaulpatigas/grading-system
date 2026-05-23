<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'faculty_id',
        'prelim',
        'midterm',
        'final',
        'average',
        'remarks',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($grade) {
            $prelim = $grade->prelim ?? 0;
            $midterm = $grade->midterm ?? 0;
            $final = $grade->final ?? 0;
            
            // 30% Prelim, 30% Midterm, 40% Final
            $grade->average = ($prelim * 0.3) + ($midterm * 0.3) + ($final * 0.4);
            
            if (!$grade->remarks) {
                $grade->remarks = $grade->average >= 75 ? 'Pass' : 'Fail';
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
