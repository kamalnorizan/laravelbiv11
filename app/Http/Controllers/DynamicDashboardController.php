<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Office;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DynamicDashboardController extends Controller
{
    public function index()
    {
        $offices = Office::pluck('city', 'officeCode');
        $years = Payment::selectRaw('YEAR(paymentDate) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        return view('dynamic-dashboard', compact('offices', 'years'));

    }

    public function loadData(Request $request)
    {
        $customer = Customer::query();
        $product = Product::query();
        $order = Order::query();
        $employee = Employee::query();

        if ($request->has('office') && $request->office != '') {
            $customer = $customer->whereHas('salesRep', function ($query) use ($request) {
                $query->where('officeCode', $request->office);
            });
            $order = $order->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('salesRep', function ($query) use ($request) {
                    $query->where('officeCode', $request->office);
                });
            });
            $employee = $employee->where('officeCode', $request->office);
        }
        $card['totalCustomers'] = $customer->count();
        $card['totalProducts'] = $product->count();
        $card['totalOrders'] = $order->count();
        $card['totalEmployees'] = $employee->count();

        $monthRev = Order::selectRaw('
        DATE_FORMAT(orderDate, "%b") as month,
        DATE_FORMAT(orderDate, "%Y") as year,
        DATE_FORMAT(orderDate, "%Y%m") as monthyear,
        SUM(CAST(orderdetails.priceEach AS DECIMAL(10,2)) * quantityOrdered) as total
    ')
            ->join('orderdetails', 'orders.orderNumber', '=', 'orderdetails.orderNumber');


        if ($request->has('office') && $request->office != '') {
            $monthRev = $monthRev->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('salesRep', function ($query) use ($request) {
                    $query->where('officeCode', $request->office);
                });
            });
        }
        $monthRev = $monthRev->groupBy('year', 'month', 'monthyear')
            ->orderBy('monthyear', 'asc')
            ->limit(12);
        if ($request->has('year') && $request->year != '') {
            $monthRev = $monthRev->whereYear('orderDate', $request->year);
        } else {
            $monthRev = $monthRev->whereYear('orderDate', date('Y'));
        }
        $monthRev = $monthRev->get();
        $data['monthRev'] = $monthRev->map(function ($item) {
            return [
                'month' => $item->month,
                'year' => $item->year,
                'monthyear' => $item->monthyear,
                'total' => $item->total,
            ];
        });


        $data['card'] = $card;
        return response()->json($data);
    }

    public function revenueDetails(Request $request)
    {
        $orders = Order::with('orderdetails');
        if ($request->has('office') && $request->office != '') {
            $orders = $orders->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('salesRep', function ($query) use ($request) {
                    $query->where('officeCode', $request->office);
                });
            });
        }

        if ($request->has('year') && $request->year != '') {
            $orders = $orders->whereYear('orderDate', $request->year);
        } else {
            $orders = $orders->whereYear('orderDate', date('Y'));
        }

        if($request->has('monthyear') && $request->monthyear != '') {
            $monthYear = Carbon::createFromFormat('Ym', $request->monthyear);
            $orders = $orders->whereYear('orderDate', $monthYear->year)
                ->whereMonth('orderDate', $monthYear->month);
        }

        return DataTables::of($orders)
            ->addColumn('customerName', function (Order $order) {
                return $order->customer->customerName;
            })
            ->addColumn('orderDate', function (Order $order) {
                return Carbon::parse($order->orderDate)->format('d M Y');
            })
            ->addColumn('status', function (Order $order) {
                return $order->status;
            })
            ->addColumn('revenue', function (Order $order) {
                if ($order->orderDetails->isEmpty()) {
                    return number_format(0, 2);
                } else {
                    $total = $order->orderDetails->sum(function ($detail) {
                        return $detail->quantityOrdered * $detail->priceEach;
                    });
                    return number_format($total, 2);
                }
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('office') && $request->office != '') {
                    $query->whereHas('customer.salesRep', function ($q) use ($request) {
                        $q->where('officeCode', $request->office);
                    });
                }
            })
            ->make(true);
    }
}
