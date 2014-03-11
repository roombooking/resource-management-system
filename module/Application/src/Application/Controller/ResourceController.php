<?php
    namespace Application\Controller;
    
    use Application\Entity\Incident as IncidentEntity;
    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;
    use Zend\View\Model\JsonModel;
    
    /**
     * ResourceController
     *
     * @author
     *
     * @version
     *
     */
    class ResourceController extends AbstractActionController
    {
        private $resourceMapper;
        
        private $incidentMapper;
        
        public function __construct($resourceMapper, $incidentMapper)
        {
        	$this->resourceMapper = $resourceMapper;
        	$this->incidentMapper = $incidentMapper;
        }
        
        public function indexAction () {
            /*
             * TODO Define an index action should it become
             * necessary.
             * 
             * The route /resources redirects to this! 
             */
            return new ViewModel(array(
        	   'hierarchies' => $this->resourceMapper->fetchAllHierarchies()
            ));
        }
        
        /**
         * Return bookings as JSON response for API use
         */
        public function containmentAction ()
        {            
            return new JsonModel($this->resourceMapper->fetchAllContainments());
        }
        
        public function containmentByIdAction ()
        {
            $id = $this->getEvent()->getRouteMatch()->getParam('id');
            
        	return new JsonModel($this->resourceMapper->fetchContainmentsById($id));
        }
        
        public function resourcesAction ()
        {
            /*
             * Logging here for demonstartion only
             * TODO remove this later...
             */
            $incident = new IncidentEntity();
            $incident->setdescription('A user opened the Resource Editor');
            $incident->setclass(0);
            $this->incidentMapper->insert($incident);
            
            $hierarchyId = $this->getEvent()->getRouteMatch()->getParam('id');
            
        	return new ViewModel(array(
        		'hierarchyId' => $hierarchyId
        	));
        }
    }
?>