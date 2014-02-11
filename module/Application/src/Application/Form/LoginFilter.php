<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
    public function __construct()
    {
        //TODO: Filter/Validator
        $this->add(array(
        	'name' => 'username',
            'required' => true
        ));
        
        //TODO: Filter/Validator
        $this->add(array(
        		'name' => 'password',
        		'required' => true
        ));
    }
}