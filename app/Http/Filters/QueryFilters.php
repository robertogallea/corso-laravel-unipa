<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilters
{

    public function __construct(protected Request $request)
    {

    }

    public function order($value)
    {
        $sortAttributes = explode(',', $value);

        foreach ($sortAttributes as $sortAttribute) {
            $dir = 'asc';
            if (str_starts_with($sortAttribute, '-')) {
                $dir = 'desc';
                $sortAttribute = substr($sortAttribute, 1);
            }

            $this->builder->orderBy($sortAttribute, $dir);
        }
    }

    public function filter(array $filters)
    {
        foreach ($filters as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }
    }

    public function include($value)
    {
        $relations = explode(',', $value);
        foreach ($relations as $relation) {
            $this->builder->with($relation);
        }

    }

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->request->all() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $builder;
    }
}
