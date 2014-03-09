<?php
namespace Application\Form;
use Zend\Form\Form;
use Zend\Form\Element;

class Booking extends Form
{
    /*
     * userMapper necessary to get the list of "repsonible" users
     */
    private $userMapper;
    
    /*
     * Time information to pre-populate the form with
     */
    private $start;
    private $end;
    
    public function __construct ($userMapper)
    {
        parent::__construct('booking');
        
        $this->userMapper = $userMapper;
    }
    
    public function initialize () {
        $this->setAttribute('action', 'create');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-add');
        $this->setAttribute('data-abide', ''); // http://foundation.zurb.com/docs/components/abide.html
        
        /*
         * TODO $this->setInputFilter
         */
        
        $this->add(
        		array(
        				'name' => 'title',
        				'attributes' => array(
        						'type' => 'text',
        						'id' => 'name',
        						'placeholder' => 'Title',
        						'autofocus' => true,
        						'required' => true
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'resourceid',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'resource'
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'startdate',
        				'attributes' => array(
        						'type' => 'date',
        						'id' => 'startdate',
        						'placeholder' => 'YYYY-MM-DD',
        				        'value' => $this->start['date'],
        						'required' => true
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'starttime',
        				'attributes' => array(
        						'type' => 'time',
        						'id' => 'starttime',
        						'placeholder' => 'HH:MM',
        				        'value' => $this->start['time']
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'enddate',
        				'attributes' => array(
        						'type' => 'date',
        						'id' => 'enddate',
        						'placeholder' => 'YYYY-MM-DD',
        				        'value' => $this->end['date'],
        						'required' => true
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'endtime',
        				'attributes' => array(
        						'type' => 'time',
        						'id' => 'endtime',
        						'placeholder' => 'HH:MM',
        				        'value' => $this->end['time']
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'bookingdescription',
        				'attributes' => array(
        						'type' => 'textarea',
        						'id' => 'bookingdescription',
        						'placeholder' => 'Booking Description'
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'participantdescription',
        				'attributes' => array(
        						'type' => 'textarea',
        						'id' => 'participantdescription',
        						'placeholder' => 'Participant Description'
        				)
        		));
        
        /*
         * Build an Array with all possible Users from scratch
        *
        * FIXME This has the potential to be a very bad idea, should the
        * number of users grow. A text field with auto-complete function,
        * fetching values throug a JSON API is probably much much smarter...
        */
        
        $users = $this->userMapper->fetchAll();
        $usersArr = array(
        		'-1' => ""
        );
        
        foreach ($users as $user) :
        $usersArr[$user->getId()] = $user->getLastName() . ', ' . $user->getFirstName();
        endforeach;
        
        $this->add(
        		array(
        				'type' => 'Zend\Form\Element\Select',
        				'name' => 'responsibility',
        				'options' => array(
        						'value_options' => $usersArr
        				)
        		));
        
        $this->add(
        		array(
        				'type' => 'Zend\Form\Element\Csrf',
        				'name' => 'csrf',
        				'options' => array(
        						'csrf_options' => array(
        								'timeout' => 600
        						)
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'submit',
        				'type' => 'Submit',
        				'attributes' => array(
        						'value' => 'Create Booking',
        						'class' => 'button'
        				)
        		));
    }
    
    /**
    * Sets userMapper
    *
    * @param type $userMapper
    * @return void
    */
    public function setuserMapper($userMapper)
    {
            $this->userMapper = $userMapper;
    }
    
    /**
    * Gets userMapper
    *
    * @return type
    */
    public function getuserMapper()
    {
            return $this->userMapper;
    }
    
    /**
    * Sets start
    *
    * @param type $start
    * @return void
    */
    public function setstart($start)
    {
            $this->start = $start;
    }
    
    /**
    * Gets start
    *
    * @return type
    */
    public function getstart()
    {
            return $this->start;
    }
    
    /**
    * Sets end
    *
    * @param type $end
    * @return void
    */
    public function setend($end)
    {
            $this->end = $end;
    }
    
    /**
    * Gets end
    *
    * @return type
    */
    public function getend()
    {
            return $this->end;
    }
}