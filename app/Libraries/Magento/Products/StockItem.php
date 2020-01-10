<?php

namespace App\Libraries\Magento\Products;

class StockItem implements \JsonSerializable
{
  /**
   * Quantidade do estoque
   * @var int
   */
  protected $qty;

  /**
   * Esta em estoque
   * @var bool
   */
  protected $is_in_stock;

  public function __construct($qty, $is_in_stock)
  {
    $this->qty = $qty;
    $this->is_in_stock = $is_in_stock;
  }

  public function jsonSerialize()
  {
    return [
      'qty' => $this->qty,
      'is_in_stock' => $this->is_in_stock
    ];
  }
}
