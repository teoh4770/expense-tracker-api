<?php

namespace App\Actions;

use App\Enums\ExpenseType;
use App\Models\Expense;
use Error;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class UpdateExpenseAction
{
    public function execute(int $id, array $expense): void
    {
        Expense::query()
            ->findOrFail($id)
            ->update([
                'name' => $expense['name'],
                'price' => $expense['price'],
                'type' => $expense['type']
            ]);
    }
}
