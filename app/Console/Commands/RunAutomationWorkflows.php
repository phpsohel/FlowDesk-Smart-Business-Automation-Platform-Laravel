<?php

namespace App\Console\Commands;

use App\Services\WorkflowAutomationService;
use Illuminate\Console\Command;

class RunAutomationWorkflows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:run-automation-workflows';
    protected $signature = 'automation:run';
    protected $description = 'Run FlowDesk automation workflows';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
       public function handle(WorkflowAutomationService $service)
    {
        $service->run();

        $this->info('Automation workflows executed successfully.');
    }
}
