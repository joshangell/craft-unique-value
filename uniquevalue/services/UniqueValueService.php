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

  public function validate($value)
  {

    // populate model and validate

    return array('success' => true);

    // return array(
    //   'success' => false,
    //   'suggestion' => 'boo'
    // );


    // if success, return now

    // we didn't validate so make a suggestion we know
    // will validate and return it

  }

}
