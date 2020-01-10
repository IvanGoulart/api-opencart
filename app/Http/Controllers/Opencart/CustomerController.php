<?php

namespace App\Http\Controllers\Opencart;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Opencart\Customer;
use App\Models\Opencart\Address;

class CustomerController extends Controller
{

    public function index() {
        //$customer = Customer::all();
        $customer = Customer::find(1);
        $customer->address;
        dd($customer);
    }    
    
}
