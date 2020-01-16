<?php

namespace App\Http\Controllers\Api\v1\Customer\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Marketplace\Customer\Customer;
use Illuminate\Http\Request;
use App\Libraries\Customer\CustomerIntegration;
use App\Libraries\Customer\Adapter\OpenCartCustomerAdapter;

class CustomerController extends Controller
{

    /**
     * Consulta Cliente pelo CNPJ
     * @param  int  $cnpj
     * @return \Illuminate\Http\Response
     */
    public function show($cnpj)
    {

        try {

            // Obtem o cliente com base no CNPJ
            $customer = Customer::findOrFail(onlyNumbers($cnpj));
            // Obtem o endereço do cliente
            $customer->address;
            // Obtem o endereço do cliente
            $customer->phone;

            // Obtem a mensagem de erro da excessão a mensagem de erro
            $data = [
                'success' => true,
                'data' => $customer,
            ];

            return response()->json($data);
        } catch (\Exception $exception) {

            $code = 400;
            // Obtem a mensagem de erro da excessão a mensagem de erro
            $data = [
                'success' => false,
                'data' => [
                    'message' => $exception->getMessage(),
                ],
            ];
            return response()->json($data, $code);
        }
    }

    /**
     * Grava o novo cliente
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $openCartCustomerAdapter = new OpenCartCustomerAdapter(new CustomerIntegration);
        $customer = $request->all();
        return response()->json($openCartCustomerAdapter->integrate($customer));
        // return response()->json(

        //);
    }
}
