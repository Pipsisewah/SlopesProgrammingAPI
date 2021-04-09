<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'startDate',
        'endDate'
    ];

    public function company():BelongsTo{
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function feature():HasMany{
        return $this->hasMany(Feature::class);
    }

    public function createdBy():BelongsTo{
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
