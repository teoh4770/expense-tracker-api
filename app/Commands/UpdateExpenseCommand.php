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
        $id = $this->argument('id') ?? $this->chooseFromExpenseList();
        $name = $this->option('name') ?? $this->ask('What is the name of the expense?');
        $price = $this->option('price') ?? $this->ask('What is the price of the expense?');
        $type = $this->option('type') ?? $this->ask('What is the type of the expense?');

        $updateExpenseAction->execute($id, [
            'name' => $name,
            'price' => $price,
            'type' => $type
        ]);

        $this->info('Expense updated successfully');
        return Command::SUCCESS;
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }

    private function chooseFromExpenseList(): int
    {
        $expenses = Expense::query()->get();

        if ($expenses->isEmpty()) {
            $this->info('There are no expenses to remove.');
            return Command::SUCCESS;
        }

        $options = $expenses->map(function (Expense $expense) {
            return "$expense->id - $expense->name - {$expense->created_at->format('Y-m-d')}";
        });

        $selected = $this->choice(
            'Which expense do you wanna update?',
            $options->toArray()
        );

        return explode(' - ', $selected)[0];
    }
}
