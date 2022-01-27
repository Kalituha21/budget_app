<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Currency;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Liability;
use App\Repositories\BalanceRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceDataController extends Controller
{
    /** @var BalanceRepository */
    private $balanceRepository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->middleware('auth');

        $this->balanceRepository = $balanceRepository;
    }

    public function getUserBalance(): array
    {
        $userId = Auth::id();

        return [
            'assets' => $this->balanceRepository->getUserAssetsData($userId)->toArray(),
            'liabilities' => $this->balanceRepository->getUserLiabilitiesData($userId)->toArray(),
            'incomes' => $this->balanceRepository->getUserIncomesData($userId)->toArray(),
            'expenses' => $this->balanceRepository->getUserExpensesData($userId)->toArray(),
        ];
    }

    public function saveAsset(Request $request)
    {
        $userId = Auth::id();
        $amount = $request->post('amount', 0.00);
        $currency = $request->post('currency', Currency::SYSTEM_DEFAULT);

        $newAsset = new Asset();
        $newAsset->user_id = $userId;
        $newAsset->amount = $amount;
        $newAsset->currency = $currency;
        $newAsset->save();
    }

    public function saveLiability(Request $request)
    {
        $userId = Auth::id();
        $amount = $request->post('amount', 0.00);
        $currency = $request->post('currency', Currency::SYSTEM_DEFAULT);

        $newLiability = new Liability();
        $newLiability->user_id = $userId;
        $newLiability->amount = $amount;
        $newLiability->currency = $currency;
        $newLiability->save();
    }

    public function saveIncome(Request $request)
    {
        $userId = Auth::id();
        $amount = $request->post('amount', 0.00);
        $currency = $request->post('currency', Currency::SYSTEM_DEFAULT);
        $every = $request->post('every', 'month');
        $start_at = $request->post('start_at');
        $delete_at = $request->post('delete_at');

        $newIncome = new Income();
        $newIncome->user_id = $userId;
        $newIncome->amount = $amount;
        $newIncome->currency = $currency;
        $newIncome->every = $every;

        if ($start_at) {
            $newIncome->start_at = $start_at;
        }

        if ($delete_at) {
            $newIncome->delete_at = $delete_at;
        }

        $newIncome->save();
    }

    public function saveExpense(Request $request)
    {
        $userId = Auth::id();
        $amount = $request->post('amount', 0.00);
        $currency = $request->post('currency', Currency::SYSTEM_DEFAULT);
        $every = $request->post('every', 'month');
        $start_at = $request->post('start_at');
        $delete_at = $request->post('delete_at');

        $newExpense = new Expense();
        $newExpense->user_id = $userId;
        $newExpense->amount = $amount;
        $newExpense->currency = $currency;
        $newExpense->every = $every;

        if ($start_at) {
            $newExpense->start_at = $start_at;
        }

        if ($delete_at) {
            $newExpense->delete_at = $delete_at;
        }

        $newExpense->save();
    }

    public function editAsset(Request $request)
    {
        $userId = Auth::id();
        $assetId = $request->post('id');
        $asset = $this->balanceRepository->getAsset($userId, $assetId);

        if (!$asset) {
            throw new Exception('Balance data doesn\'t exist');
        }

        $amount = $request->post('amount', 0.00);
        $asset->amount = $amount;
        $asset->save();
    }

    public function editLiability(Request $request)
    {
        $userId = Auth::id();
        $liabilityId = $request->post('id');
        $liability = $this->balanceRepository->getLiability($userId, $liabilityId);

        if (!$liability) {
            throw new Exception('Balance data doesn\'t exist');
        }

        $amount = $request->post('amount', 0.00);
        $liability->amount = $amount;
        $liability->save();
    }

    public function editIncome(Request $request)
    {
        $userId = Auth::id();
        $incomeId = $request->post('id');
        $income = $this->balanceRepository->getIncome($userId, $incomeId);

        if (!$income) {
            throw new Exception('Balance data doesn\'t exist');
        }

        $amount = $request->post('amount', 0.00);
        $income->amount = $amount;
        $income->save();
    }

    public function editExpense(Request $request)
    {
        $userId = Auth::id();
        $expenseId = $request->post('id');
        $expense = $this->balanceRepository->getExpense($userId, $expenseId);

        if (!$expense) {
            throw new Exception('Balance data doesn\'t exist');
        }

        $amount = $request->post('amount', 0.00);
        $expense->amount = $amount;
        $expense->save();
    }

    public function deleteAsset(Request $request)
    {
        $userId = Auth::id();
        $assetId = $request->post('id');

        $this->balanceRepository->deleteAsset($userId, $assetId);
    }

    public function deleteLiability(Request $request)
    {
        $userId = Auth::id();
        $liabilityId = $request->post('id');

        $this->balanceRepository->deleteLiability($userId, $liabilityId);
    }

    public function deleteIncome(Request $request)
    {
        $userId = Auth::id();
        $incomeId = $request->post('id');

        $this->balanceRepository->deleteIncome($userId, $incomeId);
    }

    public function deleteExpense(Request $request)
    {
        $userId = Auth::id();
        $expenseId = $request->post('id');

        $this->balanceRepository->deleteExpense($userId, $expenseId);
    }
}
