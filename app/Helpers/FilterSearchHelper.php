<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Report;
use Exception;

class FilterSearchHelper
{
    public static function userFilter()
    {
        $generalSearch = request()->generalSearch;
        $role = request()->role;
        $account_status = request()->accountStatus;
        $query = User::query();

        try {
            if (!empty($generalSearch)) {
                $query->where(function ($q) use ($generalSearch) {
                    $q->where('name', 'like', '%' . $generalSearch . '%')
                        ->orWhere('email', 'like', '%' . $generalSearch . '%');
                });
            }

            if (!empty($role)) {
                $query->where('role', '=', $role);
            }

            if (!empty($account_status)) {
                $query->where('account_status', '=', $account_status);
            }

            return $query;
        } catch (Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ], 422);
        }
    }

    /**
     * Get query for filter
     *
     * @return mixed
     */
    public static function reportFilter()
    {
        try {
            $generalSearch = request()->generalSearch;
            $amount = request()->amount;
            $type = request()->type;
            $confirmStatus = request()->confirmStatus;
            $createdAt = request()->createdAt;
            $query = Report::query();

            if (!empty($generalSearch)) {
                $query->where(function ($q) use ($generalSearch) {
                    $q->whereHas('reporter', function ($q) use ($generalSearch) {
                        $q->where('name', 'like', '%' . $generalSearch . '%');
                    })->orWhereHas('verifier', function ($q) use ($generalSearch) {
                        $q->where('name', 'like', '%' . $generalSearch . '%');
                    });
                });
            }

            if (!empty($amount)) {
                $query->where('amount', '=', $amount);
            }

            if (!empty($type)) {
                $query->where('type', '=', $type);
            }

            if (!empty($confirmStatus)) {
                $query->where('confirm_status', '=', $confirmStatus);
            }

            if (!empty($createdAt)) {
                $query->where('created_at', 'like', '%' . $createdAt . '%');
            }

            return $query;
        } catch (Exception $e) {
            return response()->json([
                'errors' => $e->getMessage(),
            ], 422);
        }
    }
}
