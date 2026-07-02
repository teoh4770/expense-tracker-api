<?php

use App\Expense;

describe('AddExpenseCommand', function () {
    it('add an expense with options', function () {
        $expense = Expense::factory()->raw();

        $this->artisan('expense:add', [
            'name' => $expense['name'],
            '--price' => $expense['price'],
            '--type' => $expense['type']
        ])->assertExitCode(0);

        $this->assertDatabaseCount('expenses', 1);
        $this->assertDatabaseHas('expenses', [
            'name' => $expense['name'],
            'price' => $expense['price'],
            'type' => $expense['type']
        ]);
    });
});
