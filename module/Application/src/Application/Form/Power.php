<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Power Form
 *
 * This form is used to provide functionality to edit powers
 * for roles.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Power extends Form
{
    /**
     * The constructor initializes the power form.
     */
    public function __construct() {
        parent::__construct('power');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form');
        $this->setAttribute('data-abide', '');  // http://foundation.zurb.com/docs/components/abide.html
        $this->setInputFilter(new PowerFilter());
        
        $this->setHydrator(new\Zend\Stdlib\Hydrator\Reflection());
        $this->setObject(new \Application\Entity\Power());
        
        
        $this->add(array(    
        		'name' => 'roleid',
        		'type' => 'Select',
                'options' => array(
        				//'label' => 'Role',
                        
                ),   
        ));

        
        $this->add(array(
            	'name' => 'module',
                'attributes' => array(
                        'type' => 'hidden',
                        'id' => 'form-powers-module',
                        'value' => '%',
                        'disabled' => true
                ),
        ));
        
        $this->add(array(
        		'name' => 'controller',
        		'attributes' => array(
        				'type' => 'hidden',
        				'id' => 'form-powers-controller',
        		        'placeholder' => 'Controller-Name',
        		        'disabled' => true
        		),
        ));
        
        $this->add(array(
        		'name' => 'action',
        		'attributes' => array(
        				'type' => 'text',
        				'id' => 'form-powers-action',
        		        'placeholder' => 'Action-Name',
        				'required' => 'required',
        				'autofocus' => true
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
    				    'value' => 'Add Power',
        		        'class' => 'button',      
        		),
        ));
    }
}