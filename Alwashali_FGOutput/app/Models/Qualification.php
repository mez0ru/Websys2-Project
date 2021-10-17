<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qualification extends Model
{
    use HasFactory;

    protected $fillable = [
        'qualification',
        'candidate_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'candidate_id');
    }
}
