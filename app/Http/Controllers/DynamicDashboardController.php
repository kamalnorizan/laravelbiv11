<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;

class DynamicDashboardController extends Controller
{
    public function index()
    {
        return view('dynamic-dashboard');

    }

    public function loaddata(Request $request)
    {
        $customer = Customer::count();
        $product = Product::count();
        $order = Order::count();
        $employee = Employee::count();

        $data = [
            'customer' => $customer,
            'product' => $product,
            'order' => $order,
            'employee' => $employee,
        ];
        return response()->json($data);
    }
}
