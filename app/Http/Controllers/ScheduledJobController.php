<?php

namespace App\Http\Controllers;

use App\Models\ScheduledJob;
use App\Models\Notification;
use Illuminate\Http\Request;

class ScheduledJobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = ScheduledJob::when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('job_type', 'like', '%' . $request->search . '%')
                    ->orWhere('frequency', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('scheduled-jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('scheduled-jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_type' => 'required|string',
            'frequency' => 'required|string',
            'next_run_at' => 'nullable|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        ScheduledJob::create($request->all());

        return redirect()->route('scheduled-jobs.index')
            ->with('success', 'Scheduled job created successfully.');
    }

    public function show(ScheduledJob $scheduledJob)
    {
        return view('scheduled-jobs.show', compact('scheduledJob'));
    }

    public function edit(ScheduledJob $scheduledJob)
    {
        return view('scheduled-jobs.edit', compact('scheduledJob'));
    }

    public function update(Request $request, ScheduledJob $scheduledJob)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_type' => 'required|string',
            'frequency' => 'required|string',
            'next_run_at' => 'nullable|date',
            'status' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $scheduledJob->update($request->all());

        return redirect()->route('scheduled-jobs.index')
            ->with('success', 'Scheduled job updated successfully.');
    }

    public function destroy(ScheduledJob $scheduledJob)
    {
        $scheduledJob->delete();

        return redirect()->route('scheduled-jobs.index')
            ->with('success', 'Scheduled job deleted successfully.');
    }

    public function run(ScheduledJob $scheduledJob)
    {
        $scheduledJob->update([
            'last_run_at' => now(),
            'next_run_at' => $this->calculateNextRun($scheduledJob->frequency),
        ]);

        Notification::create([
            'user_id' => auth()->id(),
            'title' => 'Scheduled Job Executed',
            'message' => $scheduledJob->name . ' job has been executed successfully.',
            'type' => 'System',
            'is_read' => false,
        ]);

        return back()->with('success', 'Scheduled job executed successfully.');
    }

    private function calculateNextRun($frequency)
    {
        return match ($frequency) {
            'Hourly' => now()->addHour(),
            'Daily' => now()->addDay(),
            'Weekly' => now()->addWeek(),
            'Monthly' => now()->addMonth(),
            default => now()->addDay(),
        };
    }
}