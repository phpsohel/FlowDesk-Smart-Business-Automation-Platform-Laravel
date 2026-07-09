<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Invoice;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->filter ?? 'this_month';

        $startDate = null;
        $endDate = null;

        if ($filter == 'today') {
            $startDate = now()->startOfDay();
            $endDate = now()->endOfDay();
        } elseif ($filter == 'this_week') {
            $startDate = now()->startOfWeek();
            $endDate = now()->endOfWeek();
        } elseif ($filter == 'this_month') {
            $startDate = now()->startOfMonth();
            $endDate = now()->endOfMonth();
        } elseif ($filter == 'this_year') {
            $startDate = now()->startOfYear();
            $endDate = now()->endOfYear();
        } elseif ($filter == 'custom') {
            $startDate = $request->start_date;
            $endDate = $request->end_date;
        }

        $paymentQuery = Payment::query();
        $invoiceQuery = Invoice::query();

        if ($startDate && $endDate) {
            $paymentQuery->whereBetween('payment_date', [$startDate, $endDate]);
            $invoiceQuery->whereBetween('created_at', [$startDate, $endDate]);
        }

        $totalRevenue = (clone $paymentQuery)
            ->where('status', 'Completed')
            ->sum('amount');

        $totalPayments = (clone $paymentQuery)->count();

        $pendingPayments = (clone $paymentQuery)
            ->where('status', 'Pending')
            ->count();

        $failedPayments = (clone $paymentQuery)
            ->where('status', 'Failed')
            ->count();

        $totalInvoices = (clone $invoiceQuery)->count();

        $invoiceTotal = (clone $invoiceQuery)->sum('total');

        $completedPaymentTotal = (clone $paymentQuery)
            ->where('status', 'Completed')
            ->sum('amount');

        $outstanding = $invoiceTotal - $completedPaymentTotal;

        $totalCustomers = Customer::count();
        $totalProducts = Product::count();

        $recentPayments = Payment::with(['customer', 'invoice'])
            ->latest()
            ->take(8)
            ->get();

        $recentInvoices = Invoice::with('customer')
            ->latest()
            ->take(8)
            ->get();

        $monthlyRevenue = Payment::select(
                DB::raw('MONTH(payment_date) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'Completed')
            ->whereYear('payment_date', date('Y'))
            ->groupBy(DB::raw('MONTH(payment_date)'))
            ->pluck('total', 'month')
            ->toArray();

        $revenueChartLabels = [];
        $revenueChartData = [];

        for ($i = 1; $i <= 12; $i++) {
            $revenueChartLabels[] = date('M', mktime(0, 0, 0, $i, 1));
            $revenueChartData[] = $monthlyRevenue[$i] ?? 0;
        }

        $paymentStatusData = [
            Payment::where('status', 'Completed')->count(),
            Payment::where('status', 'Pending')->count(),
            Payment::where('status', 'Failed')->count(),
        ];

        return view('reports.index', compact(
            'filter',
            'totalRevenue',
            'totalPayments',
            'pendingPayments',
            'failedPayments',
            'totalInvoices',
            'invoiceTotal',
            'outstanding',
            'totalCustomers',
            'totalProducts',
            'recentPayments',
            'recentInvoices',
            'revenueChartLabels',
            'revenueChartData',
            'paymentStatusData'
        ));
    }
}