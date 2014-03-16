<?php
namespace Application\Form;
use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Booking Form
 *
 * This form is used to add new booking or edit existing bookings.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class Booking extends Form
{
    /**
     * Application\Mapper\User is necessary to get the list of users
     * for the "responsible user" select.
     * 
     * @var Application\Mapper\User
     */
    private $userMapper;
    
    private $start;
    private $end;
    private $isprebooking;
    private $bookingid;
    private $resourceid;
    private $hierarchyid;
    private $title;
    private $bookingdescription;
    private $participantdescription;
    
    /**
     * The constructor for the form only constructs the form but does not
     * initialize it. In order to use the array of form elements initialize()
     * has to be called.
     * 
     * The initialization had to be moved from the constructor to enable
     * populating the form with data provided in the controller.
     * 
     * @param Application\Mapper\User $userMapper
     */
    public function __construct ($userMapper)
    {
        parent::__construct('booking');
        
        $this->userMapper = $userMapper;
    }
    
    /**
     * Initializes the form, adding form elements and populating them if 
     * data is provided.
     * 
     * TODO This method calls $this->userMapper->fetchAll(true) which could be
     * problematic on larger user databases. Reorganize this.
     */
    public function initialize () {
        $this->setAttribute('action', '/bookings/create');
        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-add');
        $this->setAttribute('data-abide', ''); // http://foundation.zurb.com/docs/components/abide.html
        
        $this->setInputFilter(new BookingFilter());
        
        $this->add(
        		array(
        				'name' => 'title',
        				'attributes' => array(
        						'type' => 'text',
        						'id' => 'name',
        						'placeholder' => 'Title',
        						'autofocus' => true,
        						'required' => true,
        				        'pattern' => 'shortfieldrequired',
        				        'value' => $this->title
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
        						'placeholder' => 'Booking Description',
        				        'value' => $this->bookingdescription
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'participantdescription',
        				'attributes' => array(
        						'type' => 'textarea',
        						'id' => 'participantdescription',
        						'placeholder' => 'Participant Description',
        				        'value' => $this->participantdescription
        				)
        		));
        
        /*
         * Hidden elements for JavaScript population purposes
         */
        $this->add(
        		array(
        				'name' => 'hierarchyid',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'hierarchy',
        						'value' => $this->hierarchyid
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'resourceid',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'resource',
        				        'value' => $this->resourceid
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'starttimestamp',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'starttimestamp'
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'bookingid',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'bookingid',
        				        'value' => $this->bookingid
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'isprebooking',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'isprebooking',
        				        'value' => ($this->isprebooking ? "true" : "false")
        				)
        		));
        
        $this->add(
        		array(
        				'name' => 'endtimestamp',
        				'attributes' => array(
        						'type' => 'hidden',
        						'id' => 'endtimestamp'
        				)
        		));
        
        /*
         * Build an Array with all possible Users from scratch
         *
         * FIXME This has the potential to be a very bad idea, should the
         * number of users grow. A text field with auto-complete function,
         * fetching values throug a JSON API is probably much much smarter...
         */
        
        $users = $this->userMapper->fetchAll(true);
        
        foreach ($users as $user) :
            $usersArr[$user->getId()] = $user->getLastName() . ', ' . $user->getFirstName();
        endforeach;
        
        $this->add(
        		array(
        				'type' => 'Zend\Form\Element\Select',
        				'name' => 'responsibility',
        				'options' => array(
        				        'empty_option' => '',
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
    * Sets title
    *
    * @param type $title
    * @return void
    */
    public function settitle($title)
    {
            $this->title = $title;
    }
    
    /**
    * Gets title
    *
    * @return type
    */
    public function gettitle()
    {
            return $this->title;
    }
    
    /**
    * Sets participantdescription
    *
    * @param type $participantdescription
    * @return void
    */
    public function setparticipantdescription($participantdescription)
    {
            $this->participantdescription = $participantdescription;
    }
    
    /**
    * Gets participantdescription
    *
    * @return type
    */
    public function getparticipantdescription()
    {
            return $this->participantdescription;
    }
    
    /**
    * Sets bookingdescription
    *
    * @param type $bookingdescription
    * @return void
    */
    public function setbookingdescription($bookingdescription)
    {
            $this->bookingdescription = $bookingdescription;
    }
    
    /**
    * Gets bookingdescription
    *
    * @return type
    */
    public function getbookingdescription()
    {
            return $this->bookingdescription;
    }
    
    /**
    * Sets hierarchyid
    *
    * @param type $hierarchyid
    * @return void
    */
    public function sethierarchyid($hierarchyid)
    {
            $this->hierarchyid = $hierarchyid;
    }
    
    /**
    * Gets hierarchyid
    *
    * @return type
    */
    public function gethierarchyid()
    {
            return $this->hierarchyid;
    }
    
    /**
    * Sets resourceid
    *
    * @param type $resourceid
    * @return void
    */
    public function setresourceid($resourceid)
    {
            $this->resourceid = $resourceid;
    }
    
    /**
    * Gets resourceid
    *
    * @return type
    */
    public function getresourceid()
    {
            return $this->resourceid;
    }
    
    /**
    * Sets bookingid
    *
    * @param type $bookingid
    * @return void
    */
    public function setbookingid($bookingid)
    {
            $this->bookingid = $bookingid;
    }
    
    /**
    * Gets bookingid
    *
    * @return type
    */
    public function getbookingid()
    {
            return $this->bookingid;
    }
    
    /**
    * Sets isprebooking
    *
    * @param type $isprebooking
    * @return void
    */
    public function setisprebooking($isprebooking)
    {
            $this->isprebooking = $isprebooking;
    }
    
    /**
    * Gets isprebooking
    *
    * @return type
    */
    public function getisprebooking()
    {
            return $this->isprebooking;
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