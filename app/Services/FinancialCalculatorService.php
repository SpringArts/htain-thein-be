<?php

namespace App\Services;

use App\Enums\ConfirmStatus;
use App\Enums\FinancialType;
use App\Models\Report;
use App\Models\GeneralOutcome;
use Illuminate\Support\Facades\DB;

class FinancialCalculatorService
{
    public static function overviewCalculate(): array
    {
        $income = self::calculateSum(FinancialType::INCOME, 1);
        $outcome = self::calculateTotalOutcome();
        $regularCost = self::calculateRegularCost();
        $availableBalance = self::calculateAvailableBalance();
        $mostDepositPerson = self::findMostPerson(FinancialType::INCOME);
        $mostWithdrawPerson = self::findMostPerson(FinancialType::EXPENSE);
        $incomeRate = $income ? number_format(($income / ($income + $outcome)) * 100, 0) : 0;
        $outcomeRate = $outcome ? number_format(($outcome / ($income + $outcome)) * 100, 0) : 0;

        $data = [
            'income' => $income,
            'incomeRate' => $incomeRate,
            'outcomeRate' => $outcomeRate,
            'outcome' => $outcome,
            'regularCost' => $regularCost,
            'availableBalance' => $availableBalance,
            'mostDepositPerson' => $mostDepositPerson ? $mostDepositPerson->reporter?->name : '-',
            'mostWithdrawPerson' => $mostWithdrawPerson ? $mostWithdrawPerson->reporter?->name : '-'
        ];
        return $data;
    }

    private static function calculateSum(string $type, int $confirmStatus)
    {
        return Report::where('type', $type)
            ->where('confirm_status', $confirmStatus)
            ->sum('amount');
    }

    private static function calculateTotalOutcome()
    {
        $reportOutcome = self::calculateSum(FinancialType::EXPENSE, 1);
        $regularOutcome = self::calculateRegularCost();
        $totalOutcome = $reportOutcome + $regularOutcome;
        return $totalOutcome;
    }

    private static function calculateRegularCost()
    {
        return GeneralOutcome::sum('amount');
    }

    public static function calculateAvailableBalance()
    {
        $income = self::calculateSum(FinancialType::INCOME, 1);
        $outcome = self::calculateSum(FinancialType::EXPENSE, 1);
        $regularCost = self::calculateRegularCost();
        return $income - $outcome - $regularCost;
    }

    private static function findMostPerson($type)
    {
        return Report::where('type', $type)
            ->where('confirm_status', ConfirmStatus::CHECKED)
            ->select('reporter_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('reporter_id')
            ->orderByDesc('total_amount')
            ->first();
    }
}
