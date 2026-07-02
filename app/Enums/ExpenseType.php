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
    case Others = 'Others';
}
