<?php

namespace App\Commands;

use App\Actions\AddExpenseAction;
use App\Enums\ExpenseType;
use App\Models\Expense;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
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
    public function handle(AddExpenseAction $addExpenseAction)
    {
        $name = $this->argument('name');
        $price = $this->option('price') ?? $this->ask('What is the expense price?');
        $type = $this->option('type') ?? $this->choice('What is the expense type?', ExpenseType::values());

        $errors = $addExpenseAction->execute([
            'name' => $name,
            'price' => $price,
            'type' => $type
        ]);

        if (! empty($errors)) {
            foreach ($errors as $error) {
                $this->error($error);
            }
            return Command::FAILURE;
        }

        $this->info('Expense added successfully');
        return Command::SUCCESS;
    }

    /**
     * Define the command's schedule.
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
