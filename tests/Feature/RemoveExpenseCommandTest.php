<?php

use App\Enums\ExpenseType;
use App\Models\Expense;

describe('RemoveExpenseCommand', function () {
    it('remove an expense', function () {
        $expense = Expense::factory()->create();

        $this->artisan('expense:remove', [
            'id' => $expense->id,
        ])->assertSuccessful();

        $this->assertModelMissing($expense);
    });

    it('prompts for choosing an expense from a list if id is not provided')->skip();
});
