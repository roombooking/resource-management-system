<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * IncidentController
 *
 * @author
 *
 * @version
 *
 */
class IncidentController extends AbstractActionController
{
    /**
     *
     * @var Application\Mapper\Incident
     */
    private $incidentMapper;
    
    /**
     * The constructor for the authentication controller.
     *
     * @param Application\Mapper\Incident $incidentMapper
     */
    public function __construct($incidentMapper)
    {
    	$this->incidentMapper  = $incidentMapper;
    }

    /**
     * The default action - show the home page
     */
    public function overviewAction ()
    {
        // grab the paginator from the IncidentTable
        $paginator = $this->incidentMapper->fetchAll();
        // set the current page to what has been passed in query string, or to 1 if none set
        $paginator->setCurrentPageNumber((int) $this->params()->fromRoute('page', 1));
        // set the number of items per page to 25
        $paginator->setItemCountPerPage(25);
        
        return new ViewModel(array(
         'paginator' => $paginator
        ));
    }
}