<?php

namespace App\Libraries\Magento\Products;

class CategoryLink implements \JsonSerializable
{
  /**
   * Posição
   * @var int
   */
  protected $position;

  /**
   * Id da Categoria
   * @var bool
   */
  protected $category_id;

  public function __construct($position, $category_id)
  {
    $this->position = $position;
    $this->category_id = $category_id;
  }

  public function jsonSerialize()
  {
    return [
      'position' => $this->position,
      'category_id' => $this->category_id
    ];
  }

  /**
   * Get posição
   *
   * @return  int
   */
  public function getPosition()
  {
    return $this->position;
  }

  /**
   * Get id da Categoria
   *
   * @return  bool
   */
  public function getCategoryId()
  {
    return $this->category_id;
  }
}
