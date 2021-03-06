<?php

namespace App\Http\Controllers\Api\v1\Customer\Opencart;

use App\Http\Controllers\Controller;
use App\Models\Opencart\Customer\CustomerDocument;
use Illuminate\Http\Request;

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
            $customer = CustomerDocument::findOrFail(onlyNumbers($cnpj));
            // Obtem os dados do clientes
            $customer->customer;
            // Obtem o endereço do cliente
            $customer->customer->address;

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
        dd($request->all());
    }
}
