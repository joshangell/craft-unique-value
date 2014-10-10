<?php
namespace Craft;

/**
 * Unique Value by Josh Angell
 *
 * Custom validator to check if the given value of the requesting field is unique
 * accross all other instances of that field - a different field using this method
 * won't get counted in the check.
 *
 * @package   Unique Value
 * @author    Josh Angell
 * @copyright Copyright (c) 2014, Josh Angell
 * @link      http://www.joshangell.co.uk
 */

use CValidator;

class UniqueValueValidator extends CValidator
{

  protected function validateAttribute($object, $attribute)
  {

    // get value
    $value = $object->$attribute;

    // split out fieldHandle
    $fieldHandle = $value['fieldHandle'];
    $fieldHandle = 'field_' . $fieldHandle;

    // split out elementId
    $elementId = $value['elementId'];

    // finally split out actual field value
    $fieldValue = $value['value'];

    // cache command
    $command = craft()->db->createCommand();

    // get all fields of type UniqueValue
    $rows = $command
      ->select('elementId')
      ->from('content')
      ->where($fieldHandle.' = :fieldContent', array(':fieldContent' => $fieldValue))
      ->andWhere('elementId != :id', array(':id' => $elementId))
      ->queryAll();

    // reset command for next stage
    $command->reset();

    // if we had an elementId and there was something returned, then we're not valid!
    if ( ! is_null($elementId) && count($rows) >= 1 )
    {
      $message = Craft::t("Sorry, that value already exists.");
      $this->addError($object, $attribute, $message);
    }

  }

}
