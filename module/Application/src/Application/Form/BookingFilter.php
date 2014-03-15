<?php
namespace Application\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class BookingFilter extends InputFilter
{

    public function __construct ()
    {
        $this->add(
                array(
                        'name' => 'title',
                        'required' => true,
                        'filters' => array(
                                array(
                                        'name' => 'StripTags'
                                ),
                                array(
                                        'name' => 'StringTrim'
                                )
                        ),
                        'validators' => array(
                                array(
                                        'name' => 'not_empty'
                                ),
                                array(
                                        'name' => 'string_length',
                                        'options' => array(
                                                'min' => 4,
                                                'max' => 256
                                        )
                                )
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'resourceid',
                        'required' => true,
                        'filters' => array(
                                array(
                                        'name' => 'StringTrim'
                                )
                        ),
                        'validators' => array(
                        		array(
                        				'name' => 'digits'
                        		),
                                array(
                                		'name' => 'not_empty'
                                )
                        )
                ));
        
        $this->add(
        		array(
        				'name' => 'starttimestamp',
        				'required' => true,
        				'validators' => array(
        						array(
        								'name' => 'digits'
        						),
        						array(
        								'name' => 'not_empty'
        						),
//         				        TODO
//         				        Compare this value to the endtimestamp, to make sure start is before end
//         				        array(
//         				        		'name' => 'less_than',
//         				                'options' => array(
//                                                 'max' => ???,
//                                                 'inclusive' => true
//                                             )
//         				        )
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'endtimestamp',
        				'required' => true,
        				'validators' => array(
        						array(
        								'name' => 'digits'
        						),
        						array(
        								'name' => 'not_empty'
        						)
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'isprebooking',
        				'required' => true,
        				'validators' => array(
        						array(
        								'name' => 'in_array',
        						        'options' => array(
        						                'setHaystack' => array('true', 'false')
        				                )
        						)
        				)
        		));
        
        $this->add(
                array(
                        'name' => 'startdate',
                        'required' => true,
                        'validators' => array(
                        		array(
                        				'name' => 'date'
                        		),
                        		array(
                        				'name' => 'not_empty'
                        		)
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'starttime',
                        'required' => false,
                        'validators' => array(
                                array(
                                        'name' => 'regex',
                                        'options' => array(
                                                'pattern' => '/((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?)/is'
                                        )
                                )
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'enddate',
                        'required' => true,
                        'validators' => array(
                        		array(
                        				'name' => 'date'
                        		),
                        		array(
                        				'name' => 'not_empty'
                        		)
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'endtime',
                        'required' => false,
                        'validators' => array(
                        		array(
                        				'name' => 'regex',
                        				'options' => array(
                        						'pattern' => '/((?:(?:[0-1][0-9])|(?:[2][0-3])|(?:[0-9])):(?:[0-5][0-9])(?::[0-5][0-9])?)/is'
                        				)
                        		)
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'bookingdescription',
                        'required' => false,
                        'filters' => array(
                                array(
                                        'name' => 'StripTags'
                                ),
                                array(
                                        'name' => 'StringTrim'
                                )
                        ),
                        'validators' => array(
                        		array(
                        				'name' => 'string_length',
                        				'options' => array(
                        						'max' => 2048
                        				)
                        		)
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'participantdescription',
                        'required' => false,
                        'filters' => array(
                                array(
                                        'name' => 'StripTags'
                                ),
                                array(
                                        'name' => 'StringTrim'
                                )
                        ),
                        'validators' => array(
                        		array(
                        				'name' => 'string_length',
                        				'options' => array(
                        						'max' => 2048
                        				)
                        		)
                        )
                ));
        
        $this->add(
                array(
                        'name' => 'responsibility',
                        'required' => false,
                        'validators' => array(
                                array(
                                		'name' => 'digits'
                                )
//                              TODO
//                              This has to be checked with the database.
//
//                         		array(
//                         				'name' => 'record_exists',
//                         		        'options' => array(
//                                             'table' => 'Users',
//                                             'field' => 'userid'
//                                         )
//                         		)
                        )
                ));
    }
}