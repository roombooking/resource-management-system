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
            'required' => true,
            'filters'  => array(
            		array('name' => 'StripTags'),
            		array('name' => 'StringTrim'),
            ),
            'validators' => array(
                    array(
                    		'name' => 'NotEmpty',
                    ),
                    array(
                    		'name' => 'Regex',
                    		'options' => array(
                    				'pattern' => '/^[a-zA-Z]{3,}[\.][a-zA-Z]{3,}$/i',
                    		),
                    ),
                    array (
                    		'name' => 'StringLength',
                    		'options' => array(
                    				'encoding' => 'ASCII',
                    				'min' => '7',
                    				'max' => '256',
                    		),
                    ),
            ),
        ));
        
        //TODO: Filter/Validator
        $this->add(array(
        		'name' => 'password',
        		'required' => true,
                'filters'  => array(
                		array('name' => 'StringTrim'),
                ),
                'validators' => array(
                		array(
                				'name' => 'NotEmpty',
                		),
                		array (
                				'name' => 'StringLength',
                				'options' => array(
                						'encoding' => 'UTF-8',
                						'min' => '3',
                						'max' => '256',
                				),
                		),
                )
        ));
    }
}