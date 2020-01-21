<?php

namespace App\Libraries\Customer\Adapter;

use App\Libraries\Customer\Adapter\ICustomerAdapter;
use App\Libraries\Customer\CustomerIntegration;
use App\Libraries\Customer\Rules\CustomerValidator;
use App\Models\Marketplace\Customer\Customer;
use App\Models\Marketplace\Customer\CustomerAddress;
use App\Models\Marketplace\Customer\CustomerPhone;
use Tymon\JWTAuth\Facades\JWTAuth;
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
      //Verifica se o cliente ja existe 
      $customer = (Customer::find($data['cnpj'])) ?? new Customer;

         //Pega o warehouse id do token
        $warehouse_id = JWTAuth::getClaim('sub');

        // Adapta os dados
        $address = new CustomerAddress;
        $phone = new CustomerPhone;

        $telephone = $data['customer']['telephone'];

        //Tratamento para separar o ddd do telefone e retirar caracteres que não serao gravados
        $ddd = substr($telephone, 1, 2);

        $telephone = explode(")",$telephone);
        $telephone = $telephone[1];
        $telephone = str_replace([" ","-"], "", $telephone);
        

        //salvar a informações do Cliente
        $customer->warehouse_id = $warehouse_id;
        $customer->documentnr = $data['cnpj'];
        $customer->name = $data['customer']['firstname'] ." ". $data['customer']['lastname'];
        $customer->email = $data['customer']['email'];

        //salvar a informações do Endereço
        $address->addressid = uniqueId(40);       
        $address->documentnr = $data['cnpj'];       
        $address->address = $data['customer']['address']['address_1'];       
        $address->city = $data['customer']['address']['city'];       
        $address->addressnr = $data['customer']['address']['zone_id'];

        //salvar a informações do telefone
        $phone->phoneid = uniqueId(40);
        $phone->documentnr = $data['cnpj'];
        $phone->areacd = $ddd;
        $phone->phonenr = $telephone;

        // Tenta gravar
        $result = $this->customerIntegration->save($customer, $address, $phone);

        if (!empty($result['success'])) {
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
