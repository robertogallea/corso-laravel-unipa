<?php

namespace App\Models;

use App\Http\Filters\MovementFilters;
use App\Http\Filters\QueryFilters;
use App\Traits\HasQueryFilters;
use App\Traits\HasTotals;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movement extends Model
{
    use HasTotals;
    use HasQueryFilters;

    /** @use HasFactory<\Database\Factories\MovementFactory> */
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot(['qty']);
    }


}
