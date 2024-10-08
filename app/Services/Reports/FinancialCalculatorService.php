<?php

namespace App\Services\Reports;

use App\Enums\ConfirmStatus;
use App\Enums\FinancialType;
use App\Models\GeneralOutcome;
use App\Models\Report;
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
            'mostDepositPerson' => $mostDepositPerson?->reporter->name,
            'mostWithdrawPerson' => $mostWithdrawPerson?->reporter->name,
        ];

        return $data;
    }

    private static function calculateSum(string $type, int $confirmStatus): mixed
    {
        return Report::where('type', $type)
            ->where('confirm_status', $confirmStatus)
            ->sum('amount');
    }

    private static function calculateTotalOutcome(): float
    {
        $reportOutcome = self::calculateSum(FinancialType::EXPENSE, 1);
        $regularOutcome = self::calculateRegularCost();
        $totalOutcome = $reportOutcome + $regularOutcome;

        return $totalOutcome;
    }

    private static function calculateRegularCost(): mixed
    {
        return GeneralOutcome::sum('amount');
    }

    private static function calculateAvailableBalance(): float
    {
        $income = self::calculateSum(FinancialType::INCOME, 1);
        $outcome = self::calculateSum(FinancialType::EXPENSE, 1);
        $regularCost = self::calculateRegularCost();

        return $income - $outcome - $regularCost;
    }

    public static function checkExpensePossible(array $data): void
    {
        if ($data['type'] == FinancialType::EXPENSE) {
            $availableBalance = FinancialCalculatorService::calculateAvailableBalance();
            $amount = $data['amount'];

            if ($availableBalance < $amount) {
                if ($availableBalance <= 0) {
                    throw new \InvalidArgumentException('Current Income is 0 balance. You cannot withdraw.');
                }
                throw new \InvalidArgumentException("$availableBalance kyat is only available.");
            }
        }
    }

    private static function findMostPerson(string $type): ?Report
    {
        return Report::where('type', $type)
            ->where('confirm_status', ConfirmStatus::CHECKED)
            ->select('reporter_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('reporter_id')
            ->orderByDesc('total_amount')
            ->first();
    }
}
