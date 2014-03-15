<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Barcode\Object\Error;
use Zend\Form\Annotation\ErrorMessage;
use Application\Entity\Incident as IncidentEntity;
use Application\Entity\Booking as BookingEntity;
use \DateTime;
use \DateTimeZone;

/**
 * BookingController
 *
 * @author
 *
 * @version
 *
 */
class BookingController extends AbstractActionController
{
    /**
     * @var Application\Mapper\Booking
     */
    private $bookingMapper;
    
    private $resourceMapper;
    
    private $incidentMapper;
    
    private $bookingForm;
    
    public function __construct($bookingMapper, $bookingForm, $resourceMapper, $incidentMapper)
    {
    	$this->bookingMapper = $bookingMapper;
    	$this->resourceMapper = $resourceMapper;
    	$this->bookingForm = $bookingForm;
    	$this->incidentMapper = $incidentMapper;
    }
    
    public function indexAction () {
        // TODO
    }
    
    /**
     * Return bookings as JSON response for API use
     */
    public function listAction ()
    {
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

    public function showAction ()
    {
        $first = true;
        $booking = $this->bookingMapper->fetchBookingsById($this->getEvent()->getRouteMatch()->getParam('id'));
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
    
    public function editAction ()
    {
        $isNew = ($this->getEvent()->getRouteMatch()->getParam('id') == null ? true : false);
        
        if ($isNew) {
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
            $bookings = $this->bookingMapper->fetchBookingsById($bookingId);
            $booking;
            
            $first = true;
            foreach ($bookings as $validbooking) {
            	if ($first) {
            		$booking = $validbooking;
            	}
            }
            
            $startFormatted = array(
            		'date' => substr($booking->getb_start(), 0, 10),
            		'time' => substr($booking->getb_start(), 11, 5)
            );
            
            $endFormatted = array(
            		'date' => substr($booking->getb_end(), 0, 10),
            		'time' => substr($booking->getb_end(), 11, 5)
            );
            
            //var_dump($booking);
            
            $this->bookingForm->setstart($startFormatted);
            $this->bookingForm->setend($endFormatted);
            $this->bookingForm->setbookingid($booking->getb_bookingid());
            $this->bookingForm->sethierarchyid($booking->geth_hierarchyid());
            $this->bookingForm->setresourceid($booking->getr_resourceid());
            $this->bookingForm->setisprebooking(($booking->getb_isprebooking() == "1" ? true : false));
            $this->bookingForm->initialize();
            
            return new ViewModel(array(
                    $startFormatted,
            		$endFormatted,
            		'isPrebooking' => ($booking->getb_isprebooking() == "1" ? true : false),
            		'form' => $this->bookingForm,
                    
            ));
        }
    }
    
    public function detailsAction ()
    {
    	$id = $this->getEvent()->getRouteMatch()->getParam('id');
    
    	$booking = $this->bookingMapper->fetchBookingsById($id);
    
    	return new JsonModel($booking);
    }
    
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
                $this->bookingMapper->insert($booking);
                
                /*
                 * Log this incident
                 */
                $incident = new IncidentEntity();
                $incident->setuserid($this->userAuthentication()->getIdentity());
                $incident->setdescription('A new booking titled "' . $title . '" has been created.');
                $incident->setresourceid($resourceid);
                $incident->setclass(0);
                $this->incidentMapper->insert($incident);
                
                /*
                 * Redirect to home page
                 */
                $this->redirect()->toRoute('home');
                $this->stopPropagation();
            } else {
                throw new \Exception("Form data received is invalid.");
            }
        } else {
            throw new \Exception("No POST form data received.");
        }
    }
    
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