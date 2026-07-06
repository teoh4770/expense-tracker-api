<?php

namespace App\Commands;

use App\Actions\AddExpenseAction;
use App\Actions\UpdateExpenseAction;
use App\Enums\ExpenseType;
use App\Models\Expense;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class UpdateExpenseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:update {id? : The id of expense} {--name=} {--price=} {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update an expense record';

    /**
     * Execute the console command.
     */
    public function handle(UpdateExpenseAction $updateExpenseAction)
    {
        $id = $this->argument('id');
        $name = $this->option('name');
        $price = $this->option('price');
        $type = $this->option('type');

        $updateExpenseAction->execute($id, [
            'name' => $name,
            'price' => $price,
            'type' => $type
        ]);
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
