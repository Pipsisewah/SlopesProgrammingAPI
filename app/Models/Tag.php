<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    public $timestamps = true;

    public function feature():BelongsToMany{
        return $this->belongsToMany(
            Feature::class,
            'features_tags',
            'tag_id',
            'feature_id');
    }
}
