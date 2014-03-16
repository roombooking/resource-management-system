<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Login Form
 *
 * This form is used to provide login functionality.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Login extends Form
{
    /**
     * The constructor initializes the login form.
     */
    public function __construct() {
        parent::__construct('login');
        $this->setAttribute('action', '/login');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-signin');
        $this->setAttribute('data-abide', '');  // http://foundation.zurb.com/docs/components/abide.html
        $this->setInputFilter(new LoginFilter());
        
        $this->add(array(
        	'name' => 'username',
            'attributes' => array(
                    'type' => 'text',
                    'id' => 'name',
                    'placeholder' => 'Username',
                    'autofocus' => true,
                    'required' => true
            ),
        ));
        
        $this->add(array(
    		'name' => 'password',
    		'attributes' => array(
    				'type' => 'password',
    				'id' => 'password',
    		        'placeholder' => 'Password',
                    'required' => true
    		),
        ));
        
        $this->add(array(
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf',
             'options' => array(
                     'csrf_options' => array(
                             'timeout' => 600
                     )
             )
         ));
        
        $this->add(array(
        		'name' => 'submit',
                'type' => 'Submit',
        		'attributes' => array(
    				    'value' => 'Log in',
        		        'class' => 'button',      
        		),
        ));
    }
}