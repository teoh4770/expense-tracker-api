<?php

namespace App\Commands;

use App\Expense;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class AddExpenseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:add {name} {--price=} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add an expense record';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $price = $this->option('price');
        $type = $this->option('type');

        if (is_null($price)) {
            $price = $this->ask('What is the expense price?');
        }

        $expense = Expense::query()->create([
            'name' => $name,
            'price' => $price,
            'type' => $type
        ]);

        $this->info('Expense added successfully');
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
