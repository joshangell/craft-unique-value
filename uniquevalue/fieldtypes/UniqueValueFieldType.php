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

class UniqueValueFieldType extends BaseFieldType
{

  public function getName()
  {
    return Craft::t('Unique Value');
  }

  public function getInputHtml($name, $value)
  {

    craft()->templates->includeCssResource('uniquevalue/style.css');
    craft()->templates->includeJsResource('uniquevalue/app.js');

    return craft()->templates->render('uniquevalue/input', array(
      'name'  => $name,
      'value' => $value
    ));

  }

  public function validate($value)
  {
    // get any current errors
    $errors = parent::validate($value);

    if (!is_array($errors))
    {
      $errors = array();
    }

    // get settings - we don't have any yet but this is just here to remind me
    // what I need when we do have them...
    $settings = $this->getSettings();

    // make and populate our model
    $model = new UniqueValueModel;
    $elementId = null;
    if ( isset($this->element) )
    {
      $elementId = $this->element->id;
    }

    $model->uniqueValue = array(
      'value'       => $value,
      'fieldHandle' => $this->model->handle,
      'elementId'   => $elementId
    );

    // validate the model
    if ( !$model->validate() )
    {
      $errors = array_merge($errors, $model->getErrors('uniqueValue'));
    }

    // return errors or true
    if ($errors)
    {
      return $errors;
    }
    else
    {
      return true;
    }
  }

}
