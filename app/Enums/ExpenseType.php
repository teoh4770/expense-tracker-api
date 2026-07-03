<?php

namespace App\Enums;

enum ExpenseType: string
{
    case Groceries = 'Groceries';
    case Leisure = 'Leisure';
    case Electronics = 'Electronics';
    case Utilities = 'Utilities';
    case Clothing = 'Clothing';
    case Health = 'Health';
    case Food = 'Food';
    case Others = 'Others';

    public static function values(): array
    {
        return array_map(function ($expenseType) {
            return $expenseType->value;
        }, ExpenseType::cases());
    }
}
