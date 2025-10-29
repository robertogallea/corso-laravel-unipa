<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Annotation extends Model
{
    public function annotable(): MorphTo
    {
        return $this->morphTo();
    }
}
