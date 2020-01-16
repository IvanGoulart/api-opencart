<?php

namespace App\Libraries\Customer\Rules;

class OpencartCustomerRules extends ICustomerRules
{
  protected $rules =  [
    "cnpj" => 'required|numeric|min:14',
    "customer.firstname" => 'required|min:3',
    "customer.lastname" => 'required|min:3',
    "customer.email" => 'required|email',
    "customer.telephone" => 'required',
    "customer.date_added" => 'required|date',
    "customer.address.firstname" => 'required|min:3',
    "customer.address.lastname" => 'required|min:3',
    "customer.address.address_1" => 'required|min:3',
    "customer.address.city" => 'required|min:3',
    "customer.address.postcode" => 'required|min:3',
    //"customer.custom_field",
    //"address.address_2",
    //"address.country_id",
    //"address.zone_id",
    //"address.custom_field"
  ];
}
