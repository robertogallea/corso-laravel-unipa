<?php

namespace App\Traits;

use App\Http\Filters\QueryFilters;
use Illuminate\Database\Eloquent\Builder;

trait HasQueryFilters
{

    public function scopeFilter(Builder $builder, QueryFilters $filters): Builder
    {
        return $filters->apply($builder);
    }
}
