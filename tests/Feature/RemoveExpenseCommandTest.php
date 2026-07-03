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

    it('prompts for choosing an expense from a list if id is not provided', function () {
        $expense = Expense::factory()->create();

        $expectedChoice = "{$expense->id} - {$expense->name} ({$expense->created_at->format('Y-m-d')})";

        $this->artisan('expense:remove')
            ->expectsQuestion('What is the expense that you want to remove?', $expectedChoice)
            ->expectsOutput('Expense deleted successfully')
            ->assertSuccessful();

        $this->assertModelMissing($expense);
    });

    it('handle no expenses', function () {
        $this->artisan('expense:remove')
            ->expectsOutput('There are no expenses to remove.')
            ->assertFailed();
    });

    it('outputs an error if expense does not exist', function () {
       $this->artisan('expense:remove', ['id' => 9999])
           ->expectsOutput('Expense failed to delete')
           ->expectsOutput('There is no expense with the id of 9999')
           ->assertFailed();
    });
});
