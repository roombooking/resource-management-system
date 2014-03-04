<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Barcode\Object\Error;
use Zend\Form\Annotation\ErrorMessage;

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
    
    private $bookingForm;
    
    public function __construct($bookingMapper, $bookingForm)
    {
    	$this->bookingMapper = $bookingMapper;
    	$this->bookingForm = $bookingForm;
    }
    
    public function indexAction () {
        /*
         * TODO Define an index action should it become
         * necessary.
         * 
         * The route /bookings redirects to this! 
         */
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
             * Not all request parameters in Query.
             * Send empty response.
             */
            return new JsonModel();
        }
    }
    
    public function addAction ()
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
                return new ViewModel(array(
                		'startTime' => $this->params()->fromPost('startTime'),
                		'endTime' => $this->params()->fromPost('endTime'),
                		'allDay' => $this->params()->fromPost('allDay'),
                		'form' => $this->bookingForm
                ));
            }
        } else {
            /*
             * Not a POST request or invalid POST data.
             * Create a ViewModel without variables
             */
            return new ViewModel(array(
                    'startTime' => null,
                    'endTime' => null,
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
}