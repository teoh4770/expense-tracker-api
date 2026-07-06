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

    it('prompts a list for user to choose from so that user could update it', function () {
        $expense = Expense::factory()->create();
        $newExpense = Expense::factory()->make();

        $expectedChoice = "$expense->id - $expense->name ({$expense->created_at->format('Y-m-d')})";

        $this->artisan('expense:update')
            ->expectsQuestion('Which expense do you wanna update?', $expectedChoice)
            ->expectsQuestion('What is the name of the expense?', $newExpense->name)
            ->expectsQuestion('What is the price of the expense?', $newExpense->price)
            ->expectsQuestion('What is the type of the expense?', $newExpense->type)
            ->expectsOutput('Expense updated successfully')
            ->assertSuccessful();

        $expense->fresh();
        $this->assertModelExists($expense);
        $this->assertDatabaseHas('expenses', [
            'name' => $newExpense->name,
            'price' => $newExpense->price,
            'type' => $newExpense->type
        ]);
    });

    // handle no expense to be updated
    // exit successfully

    // handle invalid expense inputs
    // exit


});
