<?php

namespace App\Http\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MovementFilters extends QueryFilters
{


    public function status(string $value)
    {
        $this->builder->whereIn('status', explode(',', $value));
    }

    public function description($value)
    {
        $this->builder->where('description', 'like', str_replace('*', '%', $value));
    }

}
