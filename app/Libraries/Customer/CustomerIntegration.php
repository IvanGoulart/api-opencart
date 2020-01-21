<?php

namespace App\Libraries\Customer;

use App\Models\Marketplace\Customer\Customer;
use App\Models\Marketplace\Customer\CustomerAddress;
use App\Models\Marketplace\Customer\CustomerPhone;
use Illuminate\Database\QueryException;

class CustomerIntegration
{
  /**
   * Grava os dados do CUSTOMER  
   * @param Customer $customer
   * @param CustomerAddress $customerAddress
   * @param CustomerPhone $customerPhone
   * @return void
   */
  public function save(
    Customer $customer,
    CustomerAddress $customerAddress,
    CustomerPhone $customerPhone
  ) {
    try {
      $customer->save();
      $customerAddress->save();
      $customerPhone->save();
      
    } catch (QueryException $exception) {
      return [
        'sucess' => false,
        'code' => 400, // Bad Request
        'data' => $exception->getMessage(),
      ];
    }
  }
}
