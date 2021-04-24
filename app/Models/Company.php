<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'city',
        'state',
    ];

    protected $appends = [
        'industry'
    ];

    public $timestamps = true;

    public function createdBy():BelongsTo{
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function industry():BelongsTo{
        return $this->belongsTo(Industry::class);
    }

    public function project():HasMany{
        return $this->hasMany(Project::class);
    }

    public function getIndustryAttribute(){
        return $this->industry()->first();
    }
}
