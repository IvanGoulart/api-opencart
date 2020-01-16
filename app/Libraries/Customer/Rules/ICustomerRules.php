<?php

namespace App\Libraries\Customer\Rules;

use Illuminate\Support\Facades\Validator;

abstract class ICustomerRules
{
  /**
   * Array de campos validados
   * @var array
   */
  protected $rules =  [];
  /**
   * Tradução das mensagens validadas
   * @var array
   */
  protected $messages =  [];
  /**
   * Mensagens de erro   
   * @var array
   */
  protected $fails =  [];

  public function __construct(array $data)
  {
    $this->data = $data;
  }

  /**
   * Valida a strutura do objeto 
   * @param array $data dados a serem validados
   * @return array
   */
  public function validate(): array
  {
    // Faz a validação dos campos
    $validator = Validator::make($this->data, $this->rules, $this->messages);
    // Se houver erros
    if ($validator->fails()) {
      // Obtem todos erros
      $errors = $validator->errors();
      // Para cada mensagem de erro enviar mensagem e código
      foreach ($errors->all() as $message) {
        $this->fails[] = [
          "message" => $message,
        ];
      }
    }
    return $this->fails;
  }
}
