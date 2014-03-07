<?php
    namespace Application\Controller;
    
    use Zend\Mvc\Controller\AbstractActionController;
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
        /**
         * @var Application\Mapper\Booking
         */
        private $resourceMapper;
        
        public function __construct($resourceMapper)
        {
        	$this->resourceMapper = $resourceMapper;
        }
        
        public function indexAction () {
            /*
             * TODO Define an index action should it become
             * necessary.
             * 
             * The route /resources redirects to this! 
             */
            return new JsonModel();
        }
        
        /**
         * Return bookings as JSON response for API use
         */
        public function containmentAction ()
        {            
            return new JsonModel($this->resourceMapper->fetchAllContainments());
        }
    }
?>