<?php

namespace App\Http\Controllers;

use App\Models\Workflow;
use App\Models\WorkflowLog;
use Illuminate\Http\Request;

class WorkflowController extends Controller
{
    public function index(Request $request)
    {
        $workflows = Workflow::withCount('logs')
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('trigger_type', 'like', '%' . $request->search . '%')
                    ->orWhere('action_type', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('workflows.index', compact('workflows'));
    }

    public function create()
    {
        return view('workflows.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trigger_type' => 'required|string|max:255',
            'condition_type' => 'nullable|string|max:255',
            'action_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        Workflow::create([
            'name' => $request->name,
            'trigger_type' => $request->trigger_type,
            'condition_type' => $request->condition_type,
            'action_type' => $request->action_type,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('workflows.index')->with('success', 'Workflow created successfully.');
    }

    public function show(Workflow $workflow)
    {
        $workflow->load(['logs' => function ($query) {
            $query->latest()->take(20);
        }]);

        return view('workflows.show', compact('workflow'));
    }

    public function edit(Workflow $workflow)
    {
        return view('workflows.edit', compact('workflow'));
    }

    public function update(Request $request, Workflow $workflow)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'trigger_type' => 'required|string|max:255',
            'condition_type' => 'nullable|string|max:255',
            'action_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $workflow->update([
            'name' => $request->name,
            'trigger_type' => $request->trigger_type,
            'condition_type' => $request->condition_type,
            'action_type' => $request->action_type,
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('workflows.index')->with('success', 'Workflow updated successfully.');
    }

    public function destroy(Workflow $workflow)
    {
        $workflow->delete();

        return redirect()->route('workflows.index')->with('success', 'Workflow deleted successfully.');
    }

    public function run(Workflow $workflow)
    {
        if (!$workflow->is_active) {
            WorkflowLog::create([
                'workflow_id' => $workflow->id,
                'status' => 'Failed',
                'message' => 'Workflow is inactive.',
                'executed_at' => now(),
            ]);

            return back()->with('error', 'Workflow is inactive.');
        }

        WorkflowLog::create([
            'workflow_id' => $workflow->id,
            'status' => 'Completed',
            'message' => 'Workflow executed manually.',
            'executed_at' => now(),
        ]);

        return back()->with('success', 'Workflow executed successfully.');
    }
}