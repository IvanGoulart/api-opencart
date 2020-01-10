<?php

namespace App\Libraries\Magento\Products;

use App\Libraries\Magento\Products\StockItem;

class Product implements \JsonSerializable
{

  /**
   * EAN+C+embalagem
   * @var String
   */
  private $sku;
  /**
   *  desccompleta
   * @var String
   */
  protected $name;

  /**
   * Preço
   * @var float
   */
  protected $price;
  /*
   {
      "label": "Enabled",
      "value": "1"
    },
    {
      "label": "Disabled",
      "value": "2"
    }
   * @var int
   */
  protected $status;

  /*
    {
    "label": "Not Visible Individually",
      "value": "1"
    },
    {
      "label": "Catalog",
      "value": "2"
    },
    {
      "label": "Search",
      "value": "3"
    },
    {
      "label": "Catalog, Search",
      "value": "4"
    }
   * @var int
   */
  protected $visibility;

  /*
    "simple",
    "virtual",
    "configurable",
    "downloadable",
    "bundle"
   * @var String
   */
  protected $type_id = 'simple';

  /**
   * Estoque do produto
   * @var StockItem
   */
  protected $stockItem;

  /**
   * Grupo padrão de atributos.
   * @var int
   */
  protected $attribute_set_id = 4;

  /**
   * Atributos default Magento
   * @var ExtensionAttribute
   */
  protected $extension_attributes;

  /**
   * Atributos customizaveis Magento
   * @var CustomAttribute
   */
  protected $custom_attributes = [];


  public function __construct($sku, $name, $price, $type_id = 'simple',  $status = 1, $visibility = 4, $attribute_set_id = 4)
  {
    $this->sku = $sku;
    $this->name = $name;
    $this->price = $price;
    $this->status = $status;
    $this->visibility = $visibility;
    $this->type_id = $type_id;
    $this->attribute_set_id = $attribute_set_id;
  }

  public function jsonSerialize()
  {
    return  [
      'product' =>
      [
        'sku' => $this->sku,
        'name' => $this->name,
        'price' => $this->price,
        'status' => $this->status,
        'visibility' => $this->visibility,
        'type_id' => $this->type_id,
        'attribute_set_id' => $this->attribute_set_id,
        'extension_attributes' => $this->extension_attributes,
        'custom_attributes' => $this->custom_attributes,
      ]
    ];
  }

  /**
   * Get atributos default Magento
   *
   * @return  object
   */
  public function getExtensionAttributes()
  {
    return $this->extension_attributes;
  }

  /**
   * Set atributos default Magento
   *
   * @param  object  $extension_attributes  Atributos default Magento
   *
   * @return  self
   */
  public function setExtensionAttributes(ExtensionAttribute $extensionAttributes)
  {
    $this->extension_attributes = $extensionAttributes;

    return $this;
  }

  /**
   * Get atributos customizaveis Magento
   *
   * @return  object
   */
  public function getCustomAttributes()
  {
    return $this->custom_attributes;
  }

  /**
   * Set atributos customizaveis Magento
   *
   * @param  object  $custom_attributes  Atributos customizaveis Magento
   *
   * @return  array CustomAttribute
   */
  public function addCustomAttributes(CustomAttribute $customAttributes)
  {
    $this->custom_attributes[] = [
      $customAttributes->getAttributeCode() => $customAttributes->getValue()
    ];

    return $this;
  }
}
