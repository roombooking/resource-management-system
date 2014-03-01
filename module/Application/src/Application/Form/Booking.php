<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class Booking extends Form
{
    public function __construct() {
        parent::__construct('booking');
        $this->setAttribute('action', '/send');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-add');
        $this->setAttribute('data-abide', '');  // http://foundation.zurb.com/docs/components/abide.html
        
        /*
         * TODO
         * $this->setInputFilter
         */
        
        $this->add(array(
        	'name' => 'title',
            'attributes' => array(
                    'type' => 'text',
                    'id' => 'name',
                    'placeholder' => 'Title',
                    'autofocus' => true,
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
    				    'value' => 'Submit',
        		        'class' => 'button',      
        		),
        ));
    }
}