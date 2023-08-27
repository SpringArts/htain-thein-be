<?php



namespace App\Services;

use App\Models\Report;
use App\Models\GeneralOutcome;
use Illuminate\Support\Facades\DB;

class FinancialCalculatorService
{
    public static function overviewCalculate(): array
    {
        $income = self::calculateSum('Income', 1);
        $outcome = self::calculateSum('Outcome', 1);
        $regularCost = self::calculateRegularCost();
        $availableBalance = self::calculateAvailableBalance();
        $mostDepositPerson = self::findMostPerson('Income');
        $mostWithdrawPerson = self::findMostPerson('Outcome');

        $data = [
            'income' => $income,
            'outcome' => $outcome,
            'regularCost' => $regularCost,
            'availableBalance' => $availableBalance,
            'mostDepositPerson' => $mostDepositPerson ? $mostDepositPerson->reporter->name : '-',
            'mostWithdrawPerson' => $mostWithdrawPerson ? $mostWithdrawPerson->reporter->name : '-'
        ];
        return $data;
    }

    private static function calculateSum($type, $confirmStatus)
    {
        return Report::where('type', $type)
            ->where('confirm_status', $confirmStatus)
            ->sum('amount');
    }

    private static function calculateRegularCost()
    {
        return GeneralOutcome::sum('amount');
    }

    public static function calculateAvailableBalance()
    {
        $income = self::calculateSum('Income', 1);
        $outcome = self::calculateSum('Outcome', 1);
        $regularCost = self::calculateRegularCost();
        return $income - $outcome - $regularCost;
    }

    private static function findMostPerson($type)
    {
        return Report::where('type', $type)
            ->where('confirm_status', 1)
            ->select('reporter_id', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('reporter_id')
            ->orderByDesc('total_amount')
            ->first();
    }
}
