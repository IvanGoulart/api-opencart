<?php

namespace App\Libraries\Magento\Products;

class CustomAttribute implements \JsonSerializable
{
  /**
   * Atributo Magento
   * @var String
   */
  private $attribute_code;

  /**
   * Valor do atributo
   * @var String
   */
  private $value;

  public function __construct($attribute_code, $value)
  {
    $this->attribute_code = $attribute_code;
    $this->value = $value;
  }

  public function jsonSerialize()
  {
    return  [
      'attribute_code' => $this->attribute_code,
      'value' => $this->value
    ];
  }

  /**
   * Get atributo Magento
   *
   * @return  String
   */
  public function getAttributeCode()
  {
    return $this->attribute_code;
  }

  /**
   * Get valor do atributo
   *
   * @return  String
   */
  public function getValue()
  {
    return $this->value;
  }
}
