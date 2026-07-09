<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Invoice;
use App\Models\Customer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
      
        $todayPayment = Payment::whereDate('payment_date', date('Y-m-d'))
        ->where('status', 'Completed')
        ->sum('amount');
        $payments = Payment::with(['invoice', 'customer'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('customer', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                })->orWhereHas('invoice', function ($q) use ($request) {
                    $q->where('invoice_number', 'like', '%' . $request->search . '%');
                });
            })
            ->latest()
            ->paginate(10);

        return view('payments.index', compact('payments', 'todayPayment'));
    }

    public function create()
    {
        $customers = Customer::latest()->get();
        $invoices = Invoice::with('customer')->latest()->get();

        return view('payments.create', compact('customers', 'invoices'));
    }

   public function store(Request $request)
{
    $request->validate([
        'invoice_id' => 'required|exists:invoices,id',
        'customer_id' => 'required|exists:customers,id',
        'amount' => 'required|numeric|min:1',
        'payment_date' => 'required|date',
        'payment_method' => 'required|string',
        'reference' => 'nullable|string',
        'status' => 'required|string',
        'notes' => 'nullable|string',
    ]);

    $invoice = Invoice::findOrFail($request->invoice_id);

    $alreadyPaid = Payment::where('invoice_id', $invoice->id)
        ->where('status', 'Completed')
        ->sum('amount');

    $balance = $invoice->total - $alreadyPaid;

    if ($request->status == 'Completed' && $request->amount > $balance) {
        return back()
            ->withInput()
            ->withErrors([
                'amount' => 'Payment amount cannot be greater than remaining invoice balance. Balance: $' . number_format($balance, 2)
            ]);
    }

    Payment::create($request->all());

    $this->updateInvoiceStatus($request->invoice_id);

    return redirect()->route('payments.index')
        ->with('success', 'Payment created successfully.');
}

    public function show(Payment $payment)
    {
        $payment->load(['invoice', 'customer']);

        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $customers = Customer::latest()->get();
        $invoices = Invoice::with('customer')->latest()->get();

        return view('payments.edit', compact('payment', 'customers', 'invoices'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'customer_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:1',
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'reference' => 'nullable|string',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $oldInvoiceId = $payment->invoice_id;

        $payment->update($request->all());

        $this->updateInvoiceStatus($oldInvoiceId);
        $this->updateInvoiceStatus($request->invoice_id);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $invoiceId = $payment->invoice_id;

        $payment->delete();

        $this->updateInvoiceStatus($invoiceId);

        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    private function updateInvoiceStatus($invoiceId)
    {
        $invoice = Invoice::find($invoiceId);

        if (!$invoice) {
            return;
        }

        $paid = Payment::where('invoice_id', $invoice->id)
            ->where('status', 'Completed')
            ->sum('amount');

        if ($paid <= 0) {
            $invoice->status = 'unpaid';
        } elseif ($paid < $invoice->total) {
            $invoice->status = 'partial';
        } else {
            $invoice->status = 'paid';
        }

        $invoice->save();
    }
}