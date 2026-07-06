<?php

use App\Enums\ExpenseType;
use App\Models\Expense;

describe('UpdateExpenseCommand', function () {
    it('update an expense', function () {
        $expense = Expense::factory()->create();
        $newExpense = Expense::factory()->make();

        $this->artisan('expense:update', [
          'id' => $expense->id,
          '--name' => $newExpense->name,
          '--price' => $newExpense->price,
          '--type' => $newExpense->type
        ]);

        $expense->fresh();
        $this->assertModelExists($expense);
        $this->assertDatabaseHas('expenses', [
            'name' => $newExpense->name,
            'price' => $newExpense->price,
            'type' => $newExpense->type
        ]);
    });

    // prompt a list for user to choose from
    // ask for name change
    // ask for price change
    // ask for type change
    // should update

    // handle no expense to be updated
    // exit successfully

    // handle invalid expense inputs
    // exit
});
