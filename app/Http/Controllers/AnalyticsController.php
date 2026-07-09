<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'Completed')->sum('amount');
        $invoiceValue = Invoice::sum('total');

        $outstanding = max($invoiceValue - $totalRevenue, 0);

        $paidInvoices = Invoice::where('status', 'paid')->count();
        $partialInvoices = Invoice::where('status', 'partial')->count();
        $unpaidInvoices = Invoice::whereIn('status', ['unpaid', 'draft', 'overdue'])->count();

        $topCustomers = Customer::withSum(['payments as paid_amount' => function ($query) {
                $query->where('status', 'Completed');
            }], 'amount')
            ->orderByDesc('paid_amount')
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)->latest()->take(5)->get();

        $monthlyRevenue = Payment::select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'Completed')
            ->whereYear('payment_date', date('Y'))
            ->groupBy(DB::raw('MONTH(payment_date)'))
            ->pluck('total', 'month')
            ->toArray();

        $labels = [];
        $data = [];

        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
            $data[] = $monthlyRevenue[$i] ?? 0;
        }

        return view('analytics.index', compact(
            'totalRevenue',
            'invoiceValue',
            'outstanding',
            'paidInvoices',
            'partialInvoices',
            'unpaidInvoices',
            'topCustomers',
            'lowStockProducts',
            'labels',
            'data'
        ));
    }
}