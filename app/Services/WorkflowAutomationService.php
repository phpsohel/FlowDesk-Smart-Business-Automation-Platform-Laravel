<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Workflow;
use App\Models\WorkflowLog;
use App\Models\Notification;
use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Mail\WorkflowAutomationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class WorkflowAutomationService
{
    public function run()
    {
        $this->runInvoiceOverdueAutomation();
    }

    private function runInvoiceOverdueAutomation()
    {
        
         Log::info('Automation Started');
        $workflow = Workflow::where('trigger_type', 'Invoice Overdue')
            ->where('is_active', true)
            ->first();
             Log::info($workflow);

        if (!$workflow) {
            return;
        }

       $invoices = Invoice::with('customer')
    ->whereDate('due_date', '<', today())
    ->whereNotIn('status', ['paid', 'Paid', 'cancelled', 'Cancelled', 'overdue', 'Overdue'])
    ->get();

Log::info('Matched invoices count: ' . $invoices->count());
Log::info($invoices);

        foreach ($invoices as $invoice) {
            $this->executeInvoiceOverdue($workflow, $invoice);
        }
    }

    private function executeInvoiceOverdue($workflow, $invoice)
    {
        try {
            $invoice->update([
                'status' => 'overdue'
            ]);

            $template = EmailTemplate::where('type', 'Invoice Reminder')
                ->where('is_active', true)
                ->first();

            if ($template && $invoice->customer && $invoice->customer->email) {
                $subject = $this->replaceVariables($template->subject, $invoice);
                $body = $this->replaceVariables($template->body, $invoice);

                Mail::to($invoice->customer->email)
                    ->send(new WorkflowAutomationMail($subject, $body));

                EmailLog::create([
                    'email_template_id' => $template->id,
                    'to_email' => $invoice->customer->email,
                    'subject' => $subject,
                    'body' => $body,
                    'status' => 'Sent',
                    'sent_at' => now(),
                ]);
            }

            Notification::create([
                'user_id' => auth()->id(),
                'title' => 'Invoice Overdue',
                'message' => 'Invoice ' . $invoice->invoice_number . ' is overdue.',
                'type' => 'Invoice',
                'is_read' => false,
            ]);

            WorkflowLog::create([
                'workflow_id' => $workflow->id,
                'status' => 'Completed',
                'message' => 'Invoice overdue automation executed for ' . $invoice->invoice_number,
                'executed_at' => now(),
            ]);

       } catch (\Exception $e) {

    Log::error('Automation Failed: ' . $e->getMessage());
    Log::error($e->getTraceAsString());

    WorkflowLog::create([
        'workflow_id' => $workflow->id,
        'status' => 'Failed',
        'message' => $e->getMessage(),
        'executed_at' => now(),
    ]);

    EmailLog::create([
        'to_email' => $invoice->customer->email ?? 'unknown',
        'subject' => 'Automation Failed',
        'body' => $e->getMessage(),
        'status' => 'Failed',
        'error_message' => $e->getMessage(),
        'sent_at' => now(),
    ]);
}
    }

    private function replaceVariables($text, $invoice)
    {
        return str_replace(
            [
                '{{ customer_name }}',
                '{{ invoice_number }}',
                '{{ invoice_total }}',
                '{{ due_date }}',
            ],
            [
                $invoice->customer->name ?? '',
                $invoice->invoice_number,
                number_format($invoice->total, 2),
                $invoice->due_date,
            ],
            $text
        );
    }
}