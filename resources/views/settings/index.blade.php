@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
        <p class="text-gray-500 mt-1">Manage company, invoice and SMTP settings.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-100 text-green-700 px-5 py-4 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Company Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Company Name</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $setting->company_name) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Company Email</label>
                    <input type="email" name="company_email" value="{{ old('company_email', $setting->company_email) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Company Phone</label>
                    <input type="text" name="company_phone" value="{{ old('company_phone', $setting->company_phone) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Timezone</label>
                    <select name="timezone" class="w-full border rounded-xl px-4 py-3">
                        @foreach(['UTC', 'Asia/Dhaka', 'America/New_York', 'Europe/London', 'Asia/Dubai'] as $timezone)
                            <option value="{{ $timezone }}" @selected(old('timezone', $setting->timezone) == $timezone)>
                                {{ $timezone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium mb-2">Company Address</label>
                    <textarea name="company_address" rows="4"
                        class="w-full border rounded-xl px-4 py-3">{{ old('company_address', $setting->company_address) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">Invoice Settings</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">Currency</label>
                    <select name="currency" class="w-full border rounded-xl px-4 py-3">
                        @foreach(['USD', 'BDT', 'EUR', 'GBP', 'CAD'] as $currency)
                            <option value="{{ $currency }}" @selected(old('currency', $setting->currency) == $currency)>
                                {{ $currency }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Invoice Prefix</label>
                    <input type="text" name="invoice_prefix" value="{{ old('invoice_prefix', $setting->invoice_prefix) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Tax Rate (%)</label>
                    <input type="number" step="0.01" name="tax_rate" value="{{ old('tax_rate', $setting->tax_rate) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-6">SMTP Settings</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium mb-2">SMTP Host</label>
                    <input type="text" name="smtp_host" value="{{ old('smtp_host', $setting->smtp_host) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">SMTP Port</label>
                    <input type="text" name="smtp_port" value="{{ old('smtp_port', $setting->smtp_port) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">SMTP Username</label>
                    <input type="text" name="smtp_username" value="{{ old('smtp_username', $setting->smtp_username) }}"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">SMTP Password</label>
                    <input type="password" name="smtp_password"
                        placeholder="Leave blank to keep old password"
                        class="w-full border rounded-xl px-4 py-3">
                </div>

                <div>
                    <label class="block text-sm font-medium mb-2">Encryption</label>
                    <select name="smtp_encryption" class="w-full border rounded-xl px-4 py-3">
                        <option value="">None</option>
                        <option value="tls" @selected(old('smtp_encryption', $setting->smtp_encryption) == 'tls')>TLS</option>
                        <option value="ssl" @selected(old('smtp_encryption', $setting->smtp_encryption) == 'ssl')>SSL</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button class="px-8 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                Save Settings
            </button>
        </div>

    </form>

</div>
@endsection