<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasApiResponse;
use App\Http\Filters\MovementFilters;
use App\Http\Requests\Api\V1\StoreMovementRequest;
use App\Http\Requests\Api\V1\UpdateMovementRequest;
use App\Http\Resources\V1\MovementResource;
use App\Models\Movement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MovementController extends Controller
{
    use HasApiResponse;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, MovementFilters $filters)
    {
        return MovementResource::collection(Movement::query()
            ->filter($filters)
            ->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovementRequest $request)
    {
        Gate::authorize('create', Movement::class);

        $movement = Movement::create($request->mappedAttributes());

        return new MovementResource($movement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movement $movement)
    {
        return new MovementResource($movement);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovementRequest $request, Movement $movement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($movement)
    {
        try {
            $movement = Movement::findOrFail($movement);

            \Gate::authorize('delete', $movement);

            $movement->products()->detach();
            $movement->delete();

            return $this->ok('Movement deleted');
        } catch (ModelNotFoundException $e) {
            return $this->error('Movements not found.', 404);
        } catch (AuthorizationException $e) {
            return $this->error('Unauthorized.', 401);
        }

    }
}
