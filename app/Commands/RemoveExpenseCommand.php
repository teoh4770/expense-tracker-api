<?php

namespace App\Commands;

use App\Actions\RemoveExpenseAction;
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
    protected $signature = 'expense:remove {id?}';

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
}
