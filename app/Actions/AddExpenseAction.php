<?php

namespace App\Actions;

use App\Enums\ExpenseType;
use App\Models\Expense;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;

class AddExpenseAction
{
	public function execute(array $expense): array
    {
        $validator = Validator::make([
            'name' => $expense['name'],
            'price' => $expense['price'],
            'type' => $expense['type']
        ], [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
            'type' => ['required', new Enum(ExpenseType::class)],
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        Expense::query()->create([
            'name' => $expense['name'],
            'price' => $expense['price'],
            'type' => $expense['type']
        ]);

        return [];
	}
}
