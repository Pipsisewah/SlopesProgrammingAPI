<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
            'institution',
            'area',
            'study_type',
            'start_date',
            'end_date',
            'gpa',
        ];


    public function users():BelongsToMany{
        return $this->belongsToMany(User::class);
    }
}
