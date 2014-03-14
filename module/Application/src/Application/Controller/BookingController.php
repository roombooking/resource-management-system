<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Barcode\Object\Error;
use Zend\Form\Annotation\ErrorMessage;
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
    
    private $bookingForm;
    
    public function __construct($bookingMapper, $bookingForm, $resourceMapper)
    {
    	$this->bookingMapper = $bookingMapper;
    	$this->resourceMapper = $resourceMapper;
    	$this->bookingForm = $bookingForm;    	
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
            
            $this->bookingForm->initialize();
            
            return new ViewModel(array(
                    $startFormatted,
                    $endFormatted,
                    'allDay' => null,
            		'form' => $this->bookingForm
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
        $test = array();
        
        if ($this->getRequest()->isPost()) {
            $this->bookingForm->initialize();
            $this->bookingForm->setData($this->getRequest()->getPost());
            
            if ($this->bookingForm->isValid()) {
                $data = $this->bookingForm->getData();
                
                $test = array(
                		"title" => $data['title']
                );
            }
        }
        
    	return new JsonModel($test);
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
            
            if (!ctype_digit($start) || !ctype_digit($end) || !ctype_digit($hierarchyid) || !ctype_digit($resourceid)) {
                return new JsonModel(array(
                		"validRequest" => false,
                		"validResource" => null,
                		"collision" => null
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
                    $collidingBookings = $this->bookingMapper->fetchCollidingBookings($hierarchyid, $resourceid, $start, $end);
                    return new JsonModel(array(
                    		"validRequest" => true,
                    		"validResource" => true,
                    		"collision" => null
                    ));
                } else {
                    return new JsonModel(array(
                    		"validRequest" => true,
                    		"validResource" => false,
                    		"collision" => null
                    ));
                }
                
            }

        }
        
        return new JsonModel(array(
                "validRequest" => false,
                "validResource" => null,
                "collision" => null
        ));
    }
}