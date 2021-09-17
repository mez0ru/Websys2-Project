<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'job_description',
        'salary_from',
        'requirement_id',
        'salary_to',
        'apply_until',
        'social_media_accounts',
    ];

    public function requirement(){
        return $this->hasOne(Requirement::class, 'id', 'requirement_id');
    }
}