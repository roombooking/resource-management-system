<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * ApiBookingController
 *
 * @author
 *
 * @version
 *
 */
class ApiBookingController extends AbstractActionController
{
    /**
     * @var Application\Mapper\Booking
     */
    private $bookingMapper;
    
    public function __construct($bookingMapper)
    {
    	$this->bookingMapper = $bookingMapper;
    }
    
    /**
     * The default action - return bookings
     */
    public function apibookingAction ()
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
}