<?php

namespace App\Traits;

use App\Models\Annotation;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Annotable
{

    public function annotation(): MorphOne
    {
        return $this->morphOne(Annotation::class, 'annotable');
    }
}
