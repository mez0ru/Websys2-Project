<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use HasFactory;

    protected $fillable = [
        'gender',
        'age',
        'country',
        'qualifications',
        'min_work_experience',
        'min_work_experience_range_type',
    ];
}
