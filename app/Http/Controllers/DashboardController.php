<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Payment::where('status', 'Completed')->sum('amount');

        $totalInvoices = Invoice::count();

        $pendingInvoices = Invoice::whereIn('status', [
            'pending',
            'unpaid',
            'partial',
            'draft',
            'overdue',
        ])->count();

        $totalCustomers = Customer::count();

        $totalProducts = Product::count();

        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with(['customer', 'invoice'])
            ->latest()
            ->take(5)
            ->get();

        $monthlyRevenue = Payment::select(
                DB::raw('DAY(payment_date) as day'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'Completed')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->groupBy(DB::raw('DAY(payment_date)'))
            ->pluck('total', 'day')
            ->toArray();

        $chartData = [];

        for ($i = 1; $i <= now()->daysInMonth; $i++) {
            $chartData[] = $monthlyRevenue[$i] ?? 0;
        }

        $upcomingInvoices = Invoice::with('customer')
            ->whereDate('due_date', '>=', today())
            ->orderBy('due_date')
            ->take(5)
            ->get();

        $automationRuns = 0;
        $emailsSent = 0;
        $tasksCompleted = 0;

        return view('dashboard', compact(
            'totalRevenue',
            'totalInvoices',
            'pendingInvoices',
            'totalCustomers',
            'totalProducts',
            'recentInvoices',
            'recentPayments',
            'chartData',
            'upcomingInvoices',
            'automationRuns',
            'emailsSent',
            'tasksCompleted'
        ));
    }
}