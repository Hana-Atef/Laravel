<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestExam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'order'
    ];

    public function questions()
    {
        return $this->hasMany(Question::class, "test_exam_id");
    }
}
