<?php

namespace App\Repositories;

use App\Models\Asset;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Liability;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BalanceRepository
{
    /* Get all data objects */

    public function getUserAssetsData(int $userId): Collection
    {
        return Asset::query()
            ->select(['id', 'amount', 'currency'])
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function getUserLiabilitiesData(int $userId): Collection
    {
        return Liability::query()
            ->select(['id', 'amount', 'currency'])
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function getUserIncomesData(int $userId): Collection
    {
        return Income::query()
            ->select(['id', 'amount', 'currency'])
            ->where('user_id', '=', $userId)
            ->get();
    }

    public function getUserExpensesData(int $userId): Collection
    {
        return Expense::query()
            ->select(['id', 'amount', 'currency'])
            ->where('user_id', '=', $userId)
            ->get();
    }


    /* Get single data object */

    /**
     * @param int $userId
     * @param int $assetId
     * @return Model|Asset|null
     */
    public function getAsset(int $userId, int $assetId): ?Asset
    {
        return Asset::query()
            ->where('id', '=', $assetId)
            ->where('user_id', '=', $userId)
            ->first();
    }

    /**
     * @param int $userId
     * @param int $liabilityId
     * @return Model|Liability|null
     */
    public function getLiability(int $userId, int $liabilityId): ?Liability
    {
        return Liability::query()
            ->where('id', '=', $liabilityId)
            ->where('user_id', '=', $userId)
            ->first();
    }

    /**
     * @param int $userId
     * @param int $incomeId
     * @return Model|Income|null
     */
    public function getIncome(int $userId, int $incomeId): ?Income
    {
        return Income::query()
            ->where('id', '=', $incomeId)
            ->where('user_id', '=', $userId)
            ->first();
    }

    /**
     * @param int $userId
     * @param int $expenseId
     * @return Model|Expense|null
     */
    public function getExpense(int $userId, int $expenseId): ?Expense
    {
        return Expense::query()
            ->where('id', '=', $expenseId)
            ->where('user_id', '=', $userId)
            ->first();
    }


    /* Delete single data object */

    public function deleteAsset(int $userId, int $assetId): void
    {
        Asset::query()
            ->where('id', '=', $assetId)
            ->where('user_id', '=', $userId)
            ->delete();
    }

    public function deleteLiability(int $userId, int $liabilityId): void
    {
        Liability::query()
            ->where('id', '=', $liabilityId)
            ->where('user_id', '=', $userId)
            ->delete();
    }

    public function deleteIncome(int $userId, int $incomeId): void
    {
        Income::query()
            ->where('id', '=', $incomeId)
            ->where('user_id', '=', $userId)
            ->delete();
    }

    public function deleteExpense(int $userId, int $expenseId): void
    {
        Expense::query()
            ->where('id', '=', $expenseId)
            ->where('user_id', '=', $userId)
            ->delete();
    }
}
