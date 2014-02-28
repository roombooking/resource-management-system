<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PowerFilter extends InputFilter
{
    public function __construct()
    {
        //TODO: Filter/Validator
        $this->add(array(
        	'name' => 'username',
            'required' => true,
            'filters'  => array(
            		array('name' => 'StripTags'),
            		array('name' => 'StringTrim'),
            ),
        ));
    }
}