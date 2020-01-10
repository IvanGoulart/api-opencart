<?php

namespace App\Libraries\Magento\Products;

use App\Libraries\Magento\Products\CategoryLink;

class ExtensionAttribute implements \JsonSerializable
{
  /**
   * Quantidade do estoque
   * @var int
   */
  protected $stock_item;

  /**
   * Array de categorias
   * @array CategoryLink
   */
  protected $category_links = [];


  public function jsonSerialize()
  {
    return [
      'stock_item' => $this->stock_item,
      'category_links' => $this->category_links
    ];
  }

  /**
   * Get array de categorias
   *
   * @return  bool
   */
  public function getCategoryLinks()
  {
    return $this->category_links;
  }

  /**
   * Set array de categorias
   *
   * @param  bool  $category_links  Array de categorias
   *
   * @return  self
   */
  public function addCategoryLinks(CategoryLink $categoryLink)
  {
    $this->category_links[] = [
      $categoryLink->getPosition() => $categoryLink->getCategoryId()
    ];

    return $this;
  }

  /**
   * Get quantidade do estoque
   *
   * @return  int
   */
  public function getStockItem()
  {
    return $this->stock_item;
  }

  /**
   * Set quantidade do estoque
   *
   * @param  int  $stock_item  Quantidade do estoque
   *
   * @return  self
   */
  public function addStockItem(StockItem $stockItem)
  {
    $this->stock_item = $stockItem;

    return $this;
  }
}
