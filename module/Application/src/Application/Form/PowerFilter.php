<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Power Filter
 *
 * This filter filters data provided by the power form.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class PowerFilter extends InputFilter
{
    /**
     * The constructor populates the array of fields to be filtered.
     * 
     * TODO Use a validator too.
     */
    public function __construct()
    {
        $this->add(array(
        	'name' => 'controller',
            'required' => true,
            'filters'  => array(
            		array('name' => 'StripTags'),
            		array('name' => 'StringTrim'),
            ),
        ));
    }
}