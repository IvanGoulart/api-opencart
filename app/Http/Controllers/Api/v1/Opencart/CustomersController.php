<?php

namespace App\Http\Controllers\Api\v1\Opencart;

use App\Http\Controllers\Controller;

use App\Models\Opencart\Customer\Customer;
use Illuminate\Support\Facades\Hash;

class CustomersController extends Controller
{

    public function index()
    {

        $customer = Customer::find(20);

        return response()->json($customer);
    }
}
