<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\GeneralOutcome\FetchGeneralOutcomeRequest;
use App\Http\Requests\V1\App\GeneralOutcome\StoreGeneralOutcomeRequest;
use App\Http\Requests\V1\App\GeneralOutcome\UpdateGeneralOutcomeRequest;
use App\Http\Resources\GeneralOutcomeResource;
use App\Models\GeneralOutcome;
use App\UseCases\GeneralOutcome\GeneralOutcomeAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class GeneralOutcomeController extends Controller
{
    protected GeneralOutcomeAction $generalOutcomeAction;

    public function __construct(GeneralOutcomeAction $generalOutcomeAction)
    {
        $this->generalOutcomeAction = $generalOutcomeAction;
    }

    public function index(FetchGeneralOutcomeRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        return $this->generalOutcomeAction->fetchGeneralOutcome($validatedData);
    }

    public function show(GeneralOutcome $generalOutcome): JsonResponse
    {
        return response()->json(
            [
                'data' => new GeneralOutcomeResource($generalOutcome),
            ],
        );
    }

    public function store(StoreGeneralOutcomeRequest $request): JsonResponse
    {
        $formData = $request->all();
        return $this->generalOutcomeAction->storeGeneralOutcome($formData);
    }

    public function update(UpdateGeneralOutcomeRequest $request, GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('adminPermission');
        $formData = $request->safe()->all();
        return $this->generalOutcomeAction->updateGeneralOutcome($formData, $generalOutcome);
    }

    public function destroy(GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        return $this->generalOutcomeAction->deleteGeneralOutcome($generalOutcome);
    }

    public function getMonthlyGeneralOutcome(): JsonResponse
    {
        return $this->generalOutcomeAction->fetchMonthlyGeneralOutcome();
    }
}
