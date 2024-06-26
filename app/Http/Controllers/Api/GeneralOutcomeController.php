<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
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
        $data = $this->generalOutcomeAction->fetchGeneralOutcome($validatedData);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => GeneralOutcomeResource::collection($data),
            'meta' => $meta,
        ]);
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
        $this->generalOutcomeAction->storeGeneralOutcome($formData);

        return ResponseHelper::success('Successfully Created', null, 201);
    }

    public function update(UpdateGeneralOutcomeRequest $request, GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('adminPermission');
        $formData = $request->safe()->all();
        $this->generalOutcomeAction->updateGeneralOutcome($formData, $generalOutcome);

        return ResponseHelper::success('Successfully Updated', null);
    }

    public function destroy(GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        $this->generalOutcomeAction->deleteGeneralOutcome($generalOutcome);

        return ResponseHelper::success('Successfully Deleted', null);
    }

    public function getMonthlyGeneralOutcome(): JsonResponse
    {
        $data = $this->generalOutcomeAction->fetchMonthlyGeneralOutcome();

        return response()->json(
            [
                'data' => $data,
            ],
        );
    }
}
