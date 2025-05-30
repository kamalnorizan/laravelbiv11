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
        $offices = Office::pluck('city','officeCode');
        return view('dynamic-dashboard', compact('offices'));

    }

    public function loaddata(Request $request)
    {
        $customer = Customer::query();
        $product = Product::query();
        $order = Order::query();
        $employee = Employee::query();

        if($request->has('office') && $request->office != '') {
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


        return response()->json($data);
    }
}
