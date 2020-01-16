<?php

namespace App\Libraries\Customer\Adapter;

use App\Libraries\Customer\Adapter\ICustomerAdapter;
use App\Libraries\Customer\CustomerIntegration;
use App\Libraries\Customer\Rules\CustomerValidator;
use App\Models\Marketplace\Customer\Customer;
use App\Models\Marketplace\Customer\CustomerAddress;
use App\Models\Marketplace\Customer\CustomerPhone;

use Exception;

class OpenCartCustomerAdapter extends ICustomerAdapter
{
  public function __construct(CustomerIntegration $customerIntegration)
  {
    $this->customerIntegration = $customerIntegration;
  }

  public function integrate(array $data): array
  {
    try {

      // Valida os dados
      $validate = CustomerValidator::make('OpencartCustomerRules', $data);
      if (!empty($validate)) {
        throw new Exception(json_encode($validate));
      }

      // Adapta os dados
      $customer = new Customer;
      $customer->warehouse_id = 5000;
      //$customer->documentnr = $data['cnpj'];
      $address = new CustomerAddress;
      $phone = new CustomerPhone;

      // Tenta gravar
      $result = $this->customerIntegration->save($customer, $address, $phone);

      if (empty($result['success'])) {
        throw new Exception($result['data']);
      }

      //code...
    } catch (Exception $e) {
      return [
        'sucess' => false,
        'code' => 400, // Bad Request
        'data' => $e->getMessage(),
      ];
    }

    return [
      'sucess' => true,
      'code' => 200,
      'data' => 'Cadastro realizado com sucesso!'
    ];
  }
}
