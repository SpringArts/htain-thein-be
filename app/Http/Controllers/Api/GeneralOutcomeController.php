<?php

namespace App\Http\Controllers\Api;

use App\Models\GeneralOutcome;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreGeneralOutComeRequest;
use App\Http\Requests\UpdateGeneralOutComeRequest;
use App\Http\Resources\GeneralOutcomeResource;
use App\UseCases\GeneralOutcome\GeneralOutcomeAction;
use Illuminate\Http\JsonResponse;

class GeneralOutcomeController extends Controller
{
    protected $generalOutcomeAction;

    public function __construct(GeneralOutcomeAction $generalOutcomeAction)
    {
        $this->generalOutcomeAction = $generalOutcomeAction;
    }

    public function index(): JsonResponse
    {
        $data = $this->generalOutcomeAction->fetchGeneralOutcome();
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
                'data' => new GeneralOutcomeResource($generalOutcome)
            ],
        );
    }

    public function store(StoreGeneralOutComeRequest $request): JsonResponse
    {
        $this->generalOutcomeAction->storeGeneralOutcome($request->safe()->all());
        return ResponseHelper::success("Successfully Created", null);
    }

    public function update(UpdateGeneralOutComeRequest $request, GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('adminPermission');
        $this->generalOutcomeAction->updateGeneralOutcome($request->safe()->all(), $generalOutcome);
        return ResponseHelper::success("Successfully Updated", null);
    }

    public function destroy(GeneralOutcome $generalOutcome): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        $this->generalOutcomeAction->deleteGeneralOutcome($generalOutcome);
        return ResponseHelper::success("Successfully Deleted", null);
    }

    public function getMonthlyGeneralOutcome(): JsonResponse
    {
        $data = $this->generalOutcomeAction->fetchMonthlyGeneralOutcome();
        return response()->json(
            [
                'data' => $data
            ],
        );
    }
}
