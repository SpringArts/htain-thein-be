<?php

namespace App\Http\Controllers\Api;

use App\Models\GeneralOutcome;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\GeneralOutcomeRequest;
use App\Http\Resources\GeneralOutcomeResource;
use App\UseCases\GeneralOutcome\GeneralOutcomeAction;
use Illuminate\Database\Eloquent\Casts\Json;
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
        return response()->json(
            [
                'data' => GeneralOutcomeResource::collection($data)
            ],
        );
    }

    public function store(GeneralOutcomeRequest $request): JsonResponse
    {
        $data = $this->generalOutcomeAction->storeGeneralOutcome($request->all());
        return ResponseHelper::success("Successfully Created", null);
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
