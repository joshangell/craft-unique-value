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

class UniqueValueService extends BaseApplicationComponent
{

  public function validate($entryId, $fieldHandle, $value)
  {

    // populate model and validate
    $errors = array();
    $model = new UniqueValueModel;
    $model->uniqueValue = array(
      'value'       => $value,
      'fieldHandle' => $fieldHandle,
      'elementId'   => $entryId
    );

    // validate the model
    if ( !$model->validate() ) {
      $errors = array_merge($errors, $model->getErrors('uniqueValue'));
    }

    // return errors or true
    if ($errors)
    {

      // first check if value ends in a number
      $regex = preg_match('/[0-9]+$/', $value, $match);
      if ( $regex && is_numeric($match[0]) )
      {
        $i = $match[0];
      }
      else
      {
        $i = 0;
      }

      // now loop
      do {

        // add to number
        $i++;

        // strip any numbers from the end of the value
        $newValue = preg_replace("/\d+$/","",$value);

        // and append our suggestion to the stripped value
        $suggestion = $newValue . $i;

        // try validating again
        $model = new UniqueValueModel;

        $model->uniqueValue = array(
          'value'       => $suggestion,
          'fieldHandle' => $fieldHandle,
          'elementId'   => $entryId
        );

        // if it passed, set $i to false to break out of our loop
        if ( $model->validate() )
        {
          $i = false;
        }

      } while ($i > 0);

      // return false and suggestion
      return array(
        'success' => false,
        'suggestion' => $suggestion
      );

    }
    else
    {

      // yay!
      return array(
        'success' => true
      );

    }

  }

}
