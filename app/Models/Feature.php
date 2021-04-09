<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Feature extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
    ];

    public function project():BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function user():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function tag():BelongsToMany{
        return $this->belongsToMany(
            Tag::class,
            'features_tags',
            'feature_id',
            'tag_id');
    }
}
