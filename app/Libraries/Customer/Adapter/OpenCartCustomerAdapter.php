<?php

namespace App\Libraries\Customer\Adapter;

use App\Libraries\Customer\Adapter\ICustomerAdapter;
use App\Libraries\Customer\CustomerIntegration;
use App\Libraries\Customer\Rules\CustomerValidator;
use App\Models\Marketplace\Customer\Customer;
use App\Models\Marketplace\Customer\CustomerAddress;
use App\Models\Marketplace\Customer\CustomerPhone;
use Illuminate\Database\QueryException;
use Exception;

class OpenCartCustomerAdapter extends ICustomerAdapter
{
  public function __construct(CustomerIntegration $customerIntegration)
  {
    $this->customerIntegration = $customerIntegration;
  }

  public function integrate(array $customer): array
  {

    try {

      // Valida os dados
      $validate = CustomerValidator::make('OpencartCustomerRules', $customer);
      if (!empty($validate)) {
        throw new Exception(json_encode($validate));
      }

      // Adapta os dados
      $this->customerIntegration->save(new Customer, new CustomerAddress, new CustomerPhone);

      //code...
    } catch (Exception | QueryException $e) {
      return [
        'sucess' => false,
        'code' => 400, // Bad Request
        'data' => json_decode($e->getMessage()),
      ];
    }

    return [
      'sucess' => true,
      'code' => 200,
      'data' => 'Cadastro realizado com sucesso!'
    ];
  }
}
