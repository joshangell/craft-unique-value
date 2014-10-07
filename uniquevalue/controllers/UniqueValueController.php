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

class UniqueValueController extends BaseController
{

  public function actionValidate()
  {

    // only accept ajax post requests
    $this->requirePostRequest();
    $this->requireAjaxRequest();

    // get value and send to service for validation and alternate suggestions
    $value       = craft()->request->getPost('value');
    $fieldHandle = craft()->request->getPost('fieldHandle');
    $entryId     = craft()->request->getPost('entryId');
    $result      = craft()->uniqueValue->validate($entryId, $fieldHandle, $value);

    // return json response
    if ( $result['success'] ) {
      $this->returnJson(array(
        'success' => true
      ));
    } else {
      $this->returnJson(array(
        'success' => false,
        'suggestion' => $result['suggestion']
      ));
    }

  }

}
