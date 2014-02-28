<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Power extends Form
{
    public function __construct() {
        parent::__construct('power');
        $this->setAttribute('action', '/powers/add');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-poweradd');
        $this->setInputFilter(new PowerFilter());
        
        $this->add(array(    
    		'name' => 'roleid',
    		'type' => 'Select',
            'options' => array(
        				'label' => 'Role',
                        'empty_option' => 'Please choose the role',
                        'value_options' => array( 
                                '1' => 'Label 1',
                                '2' => 'Label 2',
    				    ),
            ),   
        ));
        
        $this->add(array(
        	'name' => 'module',
            'attributes' => array(
                    'type' => 'text',
                    'id' => 'form-powers-module',
                    'placeholder' => '%',
            ),
        ));
        
        $this->add(array(
        		'name' => 'controller',
        		'attributes' => array(
        				'type' => 'text',
        				'id' => 'form-powers-controller',
        				'required' => 'required',
        				'autofocus' => true
        		),
        ));
        
        $this->add(array(
        		'name' => 'action',
        		'attributes' => array(
        				'type' => 'text',
        				'id' => 'form-powers-action',
        				'required' => 'required',
        		),
        ));

        
        $this->add(array(
             'type' => 'Zend\Form\Element\Csrf',
             'name' => 'csrf',
             'options' => array(
                     'csrf_options' => array(
                             'timeout' => 100
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