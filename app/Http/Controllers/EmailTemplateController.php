<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\EmailLog;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    public function index(Request $request)
    {
        $templates = EmailTemplate::when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('subject', 'like', '%' . $request->search . '%')
                    ->orWhere('type', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('email-center.index', compact('templates'));
    }

    public function create()
    {
        return view('email-center.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        EmailTemplate::create([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('email-center.index')->with('success', 'Email template created successfully.');
    }

    public function show(EmailTemplate $email_center)
    {
        $email_center->load('logs');

        return view('email-center.show', [
            'template' => $email_center
        ]);
    }

    public function edit(EmailTemplate $email_center)
    {
        return view('email-center.edit', [
            'template' => $email_center
        ]);
    }

    public function update(Request $request, EmailTemplate $email_center)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'type' => 'required|string',
            'is_active' => 'nullable|boolean',
        ]);

        $email_center->update([
            'name' => $request->name,
            'subject' => $request->subject,
            'body' => $request->body,
            'type' => $request->type,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('email-center.index')->with('success', 'Email template updated successfully.');
    }

    public function destroy(EmailTemplate $email_center)
    {
        $email_center->delete();

        return redirect()->route('email-center.index')->with('success', 'Email template deleted successfully.');
    }

    public function logs()
    {
        $logs = EmailLog::with('template')->latest()->paginate(10);

        return view('email-center.logs', compact('logs'));
    }
}