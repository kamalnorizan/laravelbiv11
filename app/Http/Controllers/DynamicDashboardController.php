<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Office;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;

class DynamicDashboardController extends Controller
{
    public function index()
    {
        $offices = Office::pluck('city', 'officeCode');
        $years = Order::selectRaw('YEAR(orderDate) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');
        return view('dynamic-dashboard', compact('offices','years'));

    }

    public function loaddata(Request $request)
    {
        $customer = Customer::query();
        $product = Product::query();
        $order = Order::query();
        $employee = Employee::query();

        if ($request->has('office') && $request->office != '') {
            $customer->whereHas('salesRep', function ($query) use ($request) {
                $query->where('officeCode', $request->office);
            });
            $order->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('salesRep', function ($query) use ($request) {
                    $query->where('officeCode', $request->office);
                });
            });
            $employee->where('officeCode', $request->office);
        }

        $card['customer'] = $customer->count();
        $card['product'] = $product->count();
        $card['order'] = $order->count();
        $card['employee'] = $employee->count();

        $data['card'] = $card;

        $monthOrder = Order::selectRaw('DATE_FORMAT(orderDate, "%b") as month, YEAR(orderDate) as year, DATE_FORMAT(orderDate, "%Y%m") as monthyear , SUM(CAST(orderDetails.priceEach AS DECIMAL(10,2)) * orderDetails.quantityOrdered) as total')
            ->join('orderDetails', 'orders.orderNumber', '=', 'orderDetails.orderNumber');

        if ($request->has('office') && $request->office != '') {
            $monthOrder->whereHas('customer', function ($query) use ($request) {
                $query->whereHas('salesRep', function ($query) use ($request) {
                    $query->where('officeCode', $request->office);
                });
            });
        }

        if($request->has('year') && $request->year != '') {
            $monthOrder->whereYear('orderDate', $request->year);
        }else{
            $monthOrder->whereYear('orderDate', date('Y'));
        }

        $monthOrder = $monthOrder->groupBy('month', 'year', 'monthyear')
            ->orderBy('monthyear', 'asc')
            ->get();

        $data['monthOrder'] = $monthOrder->map(function ($item) {
            return [
                'month' => $item->month,
                'year' => $item->year,
                'total' => $item->total,
                'monthyear' => $item->monthyear,
            ];
        });

        return response()->json($data);
    }
}
