<?php

namespace App\Libraries\Customer;

use App\Models\Marketplace\Customer\Customer;
use App\Models\Marketplace\Customer\CustomerAddress;
use App\Models\Marketplace\Customer\CustomerPhone;

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
    } catch (\Exception $exception) {
    }
  }
}
