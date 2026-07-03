<?php

namespace App\Models;

use App\Enums\ExpenseType;
use Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /** @use HasFactory<ExpenseFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'type'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'type' => ExpenseType::class
    ];
}
