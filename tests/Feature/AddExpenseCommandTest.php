<?php

use App\Enums\ExpenseType;
use App\Models\Expense;

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

    it('prompts for type if option is missing', function () {
        $expense = Expense::factory()->raw();

        $this->artisan('expense:add', [
            'name' => $expense['name'],
            '--price' => $expense['price'],
//            '--type' => $expense['type']
        ])
            ->expectsQuestion('What is the expense type?', $expense['type'])
            ->expectsOutput('Expense added successfully')
            ->assertSuccessful();
    });

    it('exit if one of the required arguments or options is invalid', function (string $name, mixed $price, mixed $type) {
        $this->artisan('expense:add', [
            'name' => $name,
            '--price' => $price,
            '--type' => $type
        ])
            ->expectsOutput('One of the validation for name, price, type failed')
            ->assertFailed();

        $this->assertDatabaseMissing('expenses', [
            'name' => $name
        ]);
    })->with([
        'name too long' => [str_repeat('a', 256), 10, ExpenseType::Food->value],
        'price is negative' => ['Valid Name', -5, ExpenseType::Food->value],
        'price is not numeric' => ['Valid Name', 'abc', ExpenseType::Food->value],
        'empty type' => ['Valid Name', 10, ''],
        'invalid type' => ['Valid Name', 10, 'wrong type']
    ]);
});
