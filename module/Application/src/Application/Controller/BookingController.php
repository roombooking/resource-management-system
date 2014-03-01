<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

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
        	$bookings = $this->bookingMapper->fetchBookings($start, $end);
        	
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
        return new ViewModel(array(
    	   'start' => $this->getEvent()->getRouteMatch()->getParam('start'),
           'end' => $this->getEvent()->getRouteMatch()->getParam('end'),
           'type' => $this->getEvent()->getRouteMatch()->getParam('type'),
           'form' => $this->bookingForm
        ));
    }
}