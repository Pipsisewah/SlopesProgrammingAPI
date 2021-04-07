<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public $timestamps = true;

    public function createdBy():BelongsTo{
        return $this->belongsTo(User::class, "created_by", "id");
    }

    public function industry():BelongsTo{
        return $this->belongsTo(Industry::class, "industry_id", "id");
    }
}
