<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create();
        }

        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_email' => 'nullable|email|max:255',
            'company_phone' => 'nullable|string|max:255',
            'company_address' => 'nullable|string',
            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:255',
            'invoice_prefix' => 'required|string|max:20',
            'tax_rate' => 'nullable|numeric|min:0',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|string|max:255',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|string|max:255',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create();
        }

        $data = $request->all();

        if (!$request->filled('smtp_password')) {
            unset($data['smtp_password']);
        }

        $setting->update($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}