<?php

namespace App\Libraries\Customer\Adapter;

use App\Libraries\Customer\CustomerIntegration;
use App\Libraries\Customer\Adapter\ICustomer;

abstract class ICustomerAdapter
{

  /**
   * Objeto responsavel por gravar os dados no banco
   * @var App\Libraries\Customer\Adapter\CustomerIntegration;
   */
  protected $customerIntegration;

  /**
   * Recebe o objeto a que faz a integração
   * @param CustomerIntegration $customerIntegration
   */
  abstract public function __construct(CustomerIntegration $customerIntegration);

  /**
   * Adapta os dados recebidos e chama o método CustomerIntegration::save
   *
   * @param ICustomer $customer
   * @return array
   */
  abstract public function integrate(array $customer): array;
}
