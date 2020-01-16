<?php

namespace App\Libraries\Customer\Rules;

class CustomerValidator
{

  /**
   * Valida os dados conforme regra  
   * @param string $type
   * @param array $data
   * @return array
   */
  public static function make(string $type, array $data): array
  {
    switch ($type) {
      case 'OpencartCustomerRules':
        $type = new OpencartCustomerRules($data);
        break;
      default:
        return ['erro' => "O $type não esta implementado"];
        break;
    }
    return $type->validate();
  }
}
