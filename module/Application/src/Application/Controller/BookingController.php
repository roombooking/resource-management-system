<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Form\Annotation\ErrorMessage;
use Application\Entity\Incident as IncidentEntity;
use Application\Entity\Booking as BookingEntity;
use \DateTime;
use \DateTimeZone;

/**
 * BookingController
 * 
 * The booking controller contains logic to read and modify
 * bookings and to read resources.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class BookingController extends AbstractActionController
{
    /**
     * @var Application\Mapper\Booking
     */
    private $bookingMapper;
    
    /**
     * @var Application\Mapper\Resource
     */
    private $resourceMapper;
    
    /**
     * @var Application\Form\Booking
     */
    private $bookingForm;
    
    /**
     * The constructor for the booking controller.
     * 
     * @param Application\Mapper\Booking $bookingMapper
     * @param Application\Form\Booking $bookingForm
     * @param Application\Mapper\Resource $resourceMapper
     */
    public function __construct($bookingMapper, $bookingForm, $resourceMapper)
    {
    	$this->bookingMapper = $bookingMapper;
    	$this->resourceMapper = $resourceMapper;
    	$this->bookingForm = $bookingForm;
    }
    
    /**
     * The index action is not used at the moment.
     * 
     * TODO Provide some sort of list of bookings with a ViewModel.
     * 
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction () {

    }
    
    /**
     * Return bookings as JSON response for API use.
     * 
     * The listAction expects to be called from a GET request with the 
     * parameters "start" and "end" containing integer values representing
     * unix timestamps. The parameter "start" represents the start of the
     * timeframe used, the parameter "end" represents the end of the
     * timeframe used.
     * 
     * Should this action be called by a non-GET request, or without the GET
     * parameters "start" and "end" or with non-integer values for these
     * parameters, an empty JsonModel ([]) will be returned.
     * 
     * Refer to /public/js/roombooking/calendar.js for the JavaScript calling
     * this API.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function listAction ()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_calendar')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        
        $allGetValues = $this->params()->fromQuery();
        $allGetParams = array_keys($allGetValues);
        
        if (in_array("start", $allGetParams) && in_array("end", $allGetParams) ) {
        	$start = $this->params()->fromQuery('start');
        	$end = $this->params()->fromQuery('end');
            
        	if (!ctype_digit($start) || !ctype_digit($end)) {
        	    /*
        	     * Non-Numeric start/end.
        	     * Send empty reponse.
        	     */
        	    return new JsonModel();
        	}
        	
        	$bookings = $this->bookingMapper->fetchBookingsByStartEnd($start, $end);
        	
        	return new JsonModel($bookings);
        } else {
                /*
                 * Not all request parameters in Query. Send empty response.
                 */
            return new JsonModel();
        }
    }
    
    /**
     * This action supplies a ViewModel for the rendering of the booking
     * detail page.
     * 
     * It requires a route parameter "id" to be provided. In order to be
     * able to retrieve the booking entity belonging to the detail page
     * the ID is used.
     * 
     * The BookingEntity will be provided to the view along with the start
     * and end dates in the proper format ('Y-m-d\TH:i:s\Z). The DateTime
     * object assumes the time zone Europe/Berlin.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function showAction ()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_appointment_details')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        /*
         * TODO check the ID for validity
         */
        $booking = $this->bookingMapper->fetchBookingsById($this->params()->fromRoute('id'));
        
        /*
         * Retrieve first element from array
         */
        $booking = $booking->current();
        
        $startTime = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $booking->getb_start());
        $startTime->setTimezone(new DateTimeZone("Europe/Berlin"));
        
        $endTime = \DateTime::createFromFormat('Y-m-d\TH:i:s\Z', $booking->getb_end());
        $endTime->setTimezone(new DateTimeZone("Europe/Berlin"));
        
        $isPrebooking = ($booking->getb_isprebooking() == 1 ? true : false);
        
        $isPlaceBooking = ($booking->getp_placeid() != null ? true : false);
        
        return new ViewModel(array(
            'booking' => $booking,
            'start' => array(
    	       'long' => $startTime->format('l, jS F Y, H:i'),
               'short' => $startTime->format('l, jS F Y')
            ),
            'end' => array(
    	       'long' => $endTime->format('l, jS F Y, H:i'),
               'short' => $endTime->format('l, jS F Y')
            ),
            'isPrebooking' => $isPrebooking,
            'isPlaceBooking' => $isPlaceBooking
        ));
    }
    
    /**
     * This action supplies the ViewModel for the view that enables the user
     * to edit a booking or to create a new booking.
     * 
     * Whether a new booking should be created or an existing booking should
     * be updated is decided on the basis of whether the route parameter
     * "id" is set. (This parameter is configured to be optional in the routing.
     * 
     * Should the "id" parameter not be set, this action is called by directly
     * accessing the url of the route (without any parameters) or by calling
     * the url of the route with POST parameters. POST parameters are used
     * when accessing the route from the calendar GUI by selecting a date range
     * with the mouse (see /public/js/roombooking/calendar.js).
     * 
     * Should the "id" parameter not be set and should no POST parameters 
     * accompany the request, it is to be assumed, that a new booking should be created
     * and no date range has been selected in the GUI. In that case a ViewModel
     * that has not been populated is returned.
     * 
     * Should the "id" parameter be set, the bookingMapper will fetch the booking
     * with this id and will then pre-populate the bookingForm with the appropriate 
     * values retrieved from the entity. 
     * 
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function editAction ()
    {
        $isNew = ($this->getEvent()->getRouteMatch()->getParam('id') == null ? true : false);
        
        if ($isNew && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'add_own_appointment')) {
            if ($this->getRequest()->isPost()) {
            	$startTime = $this->params()->fromPost('startTime');
            	$endTime = $this->params()->fromPost('endTime');
            	$allDay = $this->params()->fromPost('allDay');
            
            	if (ctype_digit($startTime) && ctype_digit($endTime) && ($allDay === 'false' || $allDay === 'true')) {
            		/*
            		 * All POST values seem valid.
            		 * Create a ViewModel with the values.
            		 */
            		$start = DateTime::createFromFormat('U', $startTime);
            		$start->setTimezone(new DateTimeZone("Europe/Berlin"));
            
            		$end = DateTime::createFromFormat('U', $endTime);
            		$end->setTimezone(new DateTimeZone("Europe/Berlin"));
            
            		$isPrebooking = ($allDay == 'true' ? true : false);
            
            		$startFormatted = array(
            				'date' => $start->format('Y-m-d'),
            				'time' => $start->format('H:i')
            		);
            
            		$endFormatted = array(
            				'date' => $end->format('Y-m-d'),
            				'time' => $end->format('H:i')
            		);
            
            		$this->bookingForm->setstart($startFormatted);
            		$this->bookingForm->setend($endFormatted);
            		$this->bookingForm->setisprebooking($isPrebooking);
            		$this->bookingForm->initialize();
            
            		return new ViewModel(array(
            				$startFormatted,
            				$endFormatted,
            				'isPrebooking' => $isPrebooking,
            				'form' => $this->bookingForm
            		));
            	}
            } else {
            	/*
            	 * Not a POST request or invalid POST data.
            	 * Create a ViewModel without variables
            	 */
            
            	$startFormatted = array(
            			'date' => null,
            			'time' => null
            	);
            
            	$endFormatted = array(
            			'date' => null,
            			'time' => null
            	);
            
            	$this->bookingForm->setisprebooking(false);
            
            	$this->bookingForm->initialize();
            
            	return new ViewModel(array(
            			$startFormatted,
            			$endFormatted,
            			'isPrebooking' => false,    // Assume it is not a pre-booking if it is not created through the calendar ui
            			'form' => $this->bookingForm
            	));
            }
        } else {
            $bookingId = $this->getEvent()->getRouteMatch()->getParam('id');
            //TODO: fix $bookings->current(): if the id is correct just return the object
            $bookings = $this->bookingMapper->fetchBookingsById($bookingId);            
            $booking = $bookings->current();
            unset($bookings);

            // Check if user is creator
            if(($booking->getu_b_userid() == $this->userAuthentication()->getIdentity()) OR $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'edit_foreign_appointment')) {
                $startFormatted = array(
                		'date' => substr($booking->getb_start(), 0, 10),
                		'time' => substr($booking->getb_start(), 11, 5)
                );
                
                $endFormatted = array(
                		'date' => substr($booking->getb_end(), 0, 10),
                		'time' => substr($booking->getb_end(), 11, 5)
                );
                
                /*
                 * TODO Also pre-populate the field for the person responsible.
                 */
                
                $this->bookingForm->setstart($startFormatted);
                $this->bookingForm->setend($endFormatted);
                $this->bookingForm->setbookingid($booking->getb_bookingid());
                $this->bookingForm->sethierarchyid($booking->geth_hierarchyid());
                $this->bookingForm->setresourceid($booking->getr_resourceid());
                $this->bookingForm->setisprebooking(($booking->getb_isprebooking() == "1" ? true : false));
                $this->bookingForm->settitle($booking->getb_name());
                $this->bookingForm->setbookingdescription($booking->getb_description());
                $this->bookingForm->setparticipantdescription($booking->getb_participant_description());
                                
                $this->bookingForm->initialize();
    
                $this->bookingForm->get('submit')->setValue('Update');
                // person responsible
                $this->bookingForm->get('responsibility')->setValue($booking->getu_r_userid());
                
                
                return new ViewModel(array(
                        $startFormatted,
                		$endFormatted,
                		'isPrebooking' => ($booking->getb_isprebooking() == "1" ? true : false),
                		'form' => $this->bookingForm,
                        
                ));
            } else {
                $this->getResponse()->getContent(403);
                throw new \Exception('Insufficient rights to edit this booking!');
            }
        }
    }
    
    /**
     * This action is called when a booking record should be deleted.
     * It will not return a view model, but will redirect to the home
     * route in any case.
     * 
     * @return NULL
     */
    public function deleteAction ()
    {
        $id = $this->getEvent()->getRouteMatch()->getParam('id');
        
        //TODO: check if user got rights
        try {
            $bookings = $this->bookingMapper->fetchBookingsById($id);
            $booking = $bookings->current();
            unset($bookings);
        } catch(\Exception $e) {
            
        }

        if((isset($booking) && $booking->getu_b_userid() == $this->userAuthentication()->getIdentity()) OR $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'delete_foreign_appointment')) {            
            /*
             * TODO handle unset/invalid parameter
             */
            try {
                $this->bookingMapper->delete($id);
                $this->logger()->insert(0, 'Booking::delete: The booking (ID: #'. $id .') has been deleted.', $this->userAuthentication()->getIdentity(), $id);
            } catch(\Exception $e) {
                $this->logger()->insert(1, 'Booking::delete error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
            }
        }
    	/*
         * Redirect to home page
         */
        return $this->redirect()->toRoute('home');
        //$this->stopPropagation();
    }
    
    /**
     * This action returns JsonModel details for a given booking id
     * as JsonModel. It is used for providing the modal that opens
     * when an existing booking is clicked in the main view. 
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function detailsAction ()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_appointment_details')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }      
        
    	$id = $this->getEvent()->getRouteMatch()->getParam('id');
    
    	$bookings = $this->bookingMapper->fetchBookingsById($id);
    
    	return new JsonModel(array(
    	        'booking' => \Zend\Stdlib\ArrayUtils::iteratorToArray($bookings),
    	        'userid' => $this->userAuthentication()->getIdentity()
        ));
    }
    
    /**
     * The create action is used to create a new booking from data
     * provided as POST parameters.
     * 
     * Should no POST parameters be presents or should the values provided
     * fail the validation done by Application\Form\BookingFilter an
     * exception will be thrown.
     * 
     * Should the data provided pass the validation a new booking entity
     * is created. Should no bookingid be present in the POST data, it
     * is assumed that a new booking should be inserted through the
     * bookingMapper. Should a bookingid be present in the POST data, an
     * attempt will be made to update the existing booking with this id.
     * 
     * @throws \Exception
     * @return NULL
     */
    public function createAction ()
    {
        if ($this->getRequest()->isPost()) {
            $this->bookingForm->initialize();
            $this->bookingForm->setData($this->getRequest()->getPost());
            
            /*
             * TODO
             * Check for colission again (this has only been done by javascript so far)
             */
            
            if (!$this->userAuthentication()->hasIdentity()) {
                throw new \Exception("user is not authenticated.");
            }
            
            if ($this->bookingForm->isValid()) {
                
                $data = $this->bookingForm->getData();
                
                $resourceid = $data['resourceid'];
                $bookingid = $data['bookingid'];
                $starttimestamp = $data['starttimestamp'];
                $endtimestamp = $data['endtimestamp'];
                $isprebooking = ($data['isprebooking'] == "true" ? "1" : "0");
                $title = $data['title'];
                $bookingdescription = $data['bookingdescription'];
                $participantdescription = $data['participantdescription'];
                $responsibility = $data['responsibility'];                
                
                /*
                 * Create booking entity and insert it
                 */
                $booking = new BookingEntity();
                $booking->setr_resourceid($resourceid);
                $booking->setb_start($starttimestamp);
                $booking->setb_end($endtimestamp);
                $booking->setb_isprebooking($isprebooking);
                $booking->setb_name($title);
                $booking->setb_description($bookingdescription);
                $booking->setb_participant_description($participantdescription);
                $booking->setu_r_userid($responsibility);
                $booking->setu_b_userid($this->userAuthentication()->getIdentity());
                
                
                if ($bookingid == "") {
                    if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'add_own_appointment')) {
                    	$this->getResponse()->getContent(403);
                    	throw new \Exception('Insufficient rights!');
                    }
                    /*
                     * new Booking: insert
                     */
                    try {
                        $bookingId = $this->bookingMapper->insert($booking);
                        $this->logger()->insert(0, 'Booking::insert: A new booking titled "'. $booking->getb_name() .'" has been created.',  $this->userAuthentication()->getIdentity(), $bookingId, $booking->getr_resourceid());
                    } catch (\Exception $e) {
                        $this->logger()->insert(1, 'Booking::insert error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
                    }
                } else {
                    $booking->setb_bookingid($bookingid);
                    
                    $oldBookings = $this->bookingMapper->fetchBookingsById($bookingid);
                    $oldBooking = $oldBookings->current();
                    
                    if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'edit_foreign_appointment')) {
                        if($oldBooking->getu_b_userid() != $this->userAuthentication()->getIdentity()) {
                            throw new \Exception('Insufficient rights to edit this booking!');
                        }
                    }
                    
                    /*
                     * existing booking: update
                     */
                    try {
                        $this->bookingMapper->update($booking);
                        $this->logger()->insert(0, 'Booking::update: The booking titled "'. $booking->getb_name() .'" has been updated.',  $this->userAuthentication()->getIdentity(), $booking->getb_bookingid(), $booking->getr_resourceid());
                        
                    } catch(\Exception $e) {
                        $this->logger()->insert(1, 'Booking::update error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
                    }
                }                
                
                /*
                 * Redirect to home page
                 */
                return $this->redirect()->toRoute('home');
                //$this->stopPropagation();
            } else {
                throw new \Exception("Form data received is invalid.");
            }
        } else {
            throw new \Exception("No POST form data received.");
        }
    }
    
    /**
     * This action checks for colliding bookings and returns
     * a JsonModel that indicates wheter a collision occured.
     * 
     * Should the (optional) "id" route match be set, the id
     * provided is exempt from the colission check. This option
     * is used to prevent updates for bookings being denied in cases
     * where their start/end dates conflict with their old
     * start/end dates.
     * 
     * @return \Zend\View\Model\JsonModel
     */
    public function checkcollisionAction ()
    {
        $allGetValues = $this->params()->fromQuery();
        $allGetParams = array_keys($allGetValues);
        
        if (in_array("start", $allGetParams)
            && in_array("end", $allGetParams)
            && in_array("hierarchyid", $allGetParams)
            && in_array("resourceid", $allGetParams) ) {
            
            $start = $this->params()->fromQuery('start');
            $end = $this->params()->fromQuery('end');
            $hierarchyid = $this->params()->fromQuery('hierarchyid');
            $resourceid = $this->params()->fromQuery('resourceid');
            
            if (!ctype_digit($start) || !ctype_digit($end) || !ctype_digit($hierarchyid) || !ctype_digit($resourceid) || ($start > $end)) {
                return new JsonModel(array(
                		"validRequest" => false,
                		"validResource" => null,
                		"collision" => null,
                        "collidingBooking" => null
                ));
            } else {
                /*
                 * The request parameters appear to be valid.
                 * Check the input
                 */
                
                $resources = $this->resourceMapper->fetchResourceByIds($hierarchyid, $resourceid);
                $validResource = null;
                
                $hasResource = false;
                foreach ( $resources as $resource )
                {
                	if ( !$hasResource )
                	{
                		$validResource = $resource;
                		$hasResource = true;
                	}
                }
                
                if ($hasResource && $validResource->getr_isdeleted() == "0" && $validResource->getr_isbookable() == "1") {
                    $bookingId = $this->getEvent()->getRouteMatch()->getParam('id');

                    if ($bookingId == null) {
                        /*
                         * This collission call is for
                         * a new booking.
                         */
                        $bookings = $this->bookingMapper->fetchCollidingBookings($hierarchyid, $resourceid, $start, $end);
                    } else {
                        /*
                         * This collission call is for
                         * an exisitng booking.
                         */
                        $bookings = $this->bookingMapper->fetchCollidingBookingsForExistingBooking($hierarchyid, $resourceid, $bookingId, $start, $end);
                    }
                    
                    
                    $collidingBookingName = null;
                    $collidingBookingId = null;
                    $isColliding = false;
                    foreach ( $bookings as $booking )
                    {
                    	if ( !$isColliding )
                    	{
                    		$collidingBooking = $booking;
                    		$collidingBookingName = $collidingBooking->getb_name();
                    		$collidingBookingId = $collidingBooking->getb_bookingid();
                    		$isColliding = true;
                    	}
                    }
                    
                    return new JsonModel(array(
                    		"validRequest" => true,
                    		"validResource" => true,
                    		"collision" => $isColliding,
                            "collidingBooking" => array(
                                "collidingBookingName" => $collidingBookingName,
                                "collidingBookingId" => $collidingBookingId
                            )
                    ));
                } else {
                    return new JsonModel(array(
                    		"validRequest" => true,
                    		"validResource" => false,
                    		"collision" => null,
                            "collidingBooking" => null
                    ));
                }
                
            }

        }
        
        return new JsonModel(array(
                "validRequest" => false,
                "validResource" => null,
                "collision" => null,
                "collidingBooking" => null
        ));
    }
}