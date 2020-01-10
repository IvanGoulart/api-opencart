<?php

namespace App\Libraries\Magento\Utils;

class SearchCriteria
{
  /**
   * Campo a ser filtrado
   * @var String
   */
  private $field = 'searchCriteria[filter_groups][0][filters][0][field]=';
  /**
   * Valor
   * @var String
   */
  private $value = 'searchCriteria[filter_groups][0][filters][0][value]=';
  /**
   * Condição do filtro
   * @var String
   */
  private $condition_type = 'searchCriteria[filter_groups][0][filters][0][condition_type]=';

  public function __construct(String $field, String $value, String $condition_type)
  {
    $this->field .= $field;
    $this->value .= $value;
    $this->condition_type .= $condition_type;
  }

  /**
   * Get campo a ser filtrado
   *
   * @return  String
   */
  public function getField()
  {
    return $this->field;
  }

  /**
   * Get valor
   *
   * @return  String
   */
  public function getValue()
  {
    return $this->value;
  }

  /*
   Condition	Notes
    eq    	=> Equals.
    finset	=> A value within a set of values
    from  	=> The beginning of a range. Must be used with to
    gt    	=> Greater than
    gteq  	=> Greater than or equal
    in	    => In. The value can contain a comma-separated list of values.
    like	  => Like. The value can contain the SQL wildcard characters when like is specified.
    lt	    => Less than
    lteq	  => Less than or equal
    moreq 	=> More or equal
    neq	    => Not equal
    nfinset	=> A value that is not within a set of values
    nin	    => Not in. The value can contain a comma-separated list of values.
    not     =>null	Not null
    null  	=> Null
    to	    => The end of a range. Must be used with from
   * @return  String
   */
  public function getConditionType()
  {
    return $this->condition_type;
  }
}
