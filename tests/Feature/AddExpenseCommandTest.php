<?php

use App\Expense;

describe('AddExpenseCommand', function () {
    it('add an expense with options', function () {
        $expense = Expense::factory()->raw();

        $this->artisan('expense:add', [
            'name' => $expense['name'],
            '--price' => $expense['price'],
            '--type' => $expense['type']
        ])->assertSuccessful();

        $this->assertDatabaseCount('expenses', 1);
        $this->assertDatabaseHas('expenses', [
            'name' => $expense['name'],
            'price' => $expense['price'],
            'type' => $expense['type']
        ]);
    });

    it('prompts for price if option is missing', function () {
        $expense = Expense::factory()->raw();

        $this->artisan('expense:add', [
            'name' => $expense['name'],
            // '--price' => $expense['price'],
            '--type' => $expense['type']
        ])
            ->expectsQuestion('What is the expense price?', $expense['price'])
            ->expectsOutput('Expense added successfully')
            ->assertSuccessful();
    });
});
