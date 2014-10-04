<?php
namespace Craft;

/**
 * Unique Value by Josh Angell
 *
 * @package   Unique Value
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Josh Angell
 * @link      http://www.joshangell.co.uk
 */

class UniqueValueModel extends BaseModel
{

  protected function defineAttributes()
  {
    return array(
      'uniqueValue' => array(
        'type'     => AttributeType::String,
        'required' => true
      ),
    );
  }

  public function rules()
  {
    $rules = parent::rules();

    $rules[] = array('uniqueValue', 'Craft\UniqueValueValidator');

    return $rules;
  }

}
