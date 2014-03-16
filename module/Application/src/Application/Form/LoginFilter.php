<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Login Filter
 *
 * This filter validates and filters data provided by the login
 * form.
 * 
 * Specifically it checks for the correct syntax of username and
 * password.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class LoginFilter extends InputFilter
{
    /**
     * The constructor populates the array of fields
     * to be validated along with their validation methods.
     */
    public function __construct()
    {
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