<?php

namespace App\Commands;

use App\Actions\RemoveExpenseAction;
use App\Models\Expense;
use Error;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class RemoveExpenseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expense:remove {id? : The id of expense}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove an expense record from the list';

    /**
     * Execute the console command.
     */
    public function handle(RemoveExpenseAction $removeExpenseAction)
    {
        $id = $this->argument('id');

        if (empty($id)) {
            $id = $this->chooseFromExpenseList();
        }

        try {
            $removeExpenseAction->execute($id);
        } catch (Error $e) {
            $this->error('Expense failed to delete');
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        $this->info('Expense deleted successfully');
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
            'What is the expense that you want to remove?',
            $options->toArray()
        );

        return explode(' - ', $selected)[0];
    }
}
