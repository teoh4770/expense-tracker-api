<?php

namespace App\Actions;

use App\Enums\ExpenseType;
use App\Models\Expense;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class RemoveExpenseAction
{
	public function execute(int $id): void
    {
        $expense = Expense::query()->where('id', $id);

        if ($expense->doesntExist()) {
            throw new Error("There is no expense with the id of $id");
        }

        $expense->delete();
	}
}
