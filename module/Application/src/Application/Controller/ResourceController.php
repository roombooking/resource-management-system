<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Application\Entity\Containment as ContainmentEntity;
    
/**
 * ResourceController
 * 
 * The resource controller contains logic to read and modify resources.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class ResourceController extends AbstractActionController
{
/**
 * 
 * @var Application\Mapper\Resource
 */
private $resourceMapper;

/**
 * 
 * The constructor for the resource controller.
 * 
 * @param Application\Mapper\Resource $resourceMapper
 */
public function __construct($resourceMapper)
{
	$this->resourceMapper = $resourceMapper;
}

/**
 * The index action provies an overview over all hierarchies available.
 * 
 * It aims to provide data for a simple overview page that allows administrators
 * to pick a hierarchy to adminsitrate.
 * 
 * (non-PHPdoc)
 * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
 */
    public function indexAction () {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_resource_list')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        
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
 	* Return containments as JSON response for API use. This action
 	* is vital to the jsTree JavaScript logic !(see /public/js/roombooking/roombooking.js)
 	* 
 	* FIXME: not used
 	* 
 	* @return \Zend\View\Model\JsonModel
 	*/
    public function containmentAction ()
    {
        if($this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'add_own_appointment')) {
        	return new JsonModel($this->resourceMapper->fetchAllContainments());
        } else {
        	return $this->getResponse()->setStatusCode(403);
        }
    }
    
    /**
     * Return containment as JSON response for API use. This action
     * is meant to be used for editing trees (see /public/js/roombooking/edittree.js)
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function containmentByIdAction ()
    {        
        if($this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_resource_list')) {
        	$id = $this->params()->fromRoute('id');
        
    	    return new JsonModel($this->resourceMapper->fetchContainmentsById($id));
        } else {
        	return $this->getResponse()->setStatusCode(403);
        }
    }
    
    /**
     * This action supplies the view for the resource administration.
     * The hierarhcyid is provided to allow the view to build
     * the tree with jsTree.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function resourcesAction ()
    {   
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_resource_list')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        
        $hierarchyId = $this->params()->fromRoute('id');
        
    	return new ViewModel(array(
    		'hierarchyId' => $hierarchyId
    	));
    }
    

    /**
     * Return resource as JSON response for API use. This action
     * is meant to be used for editing trees (see /public/js/roombooking/edittree.js)
     *
     * @return \Zend\View\Model\JsonModel, \Zend\
     */
    public function resourceByIdAction ()
    {        
        if($this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_resource_details')) {
        	$hierachyid = $this->params()->fromRoute('id');
        	$resourceid = $this->params()->fromRoute('rid');
        
        	return new JsonModel($this->resourceMapper->fetchResourceByIds($hierachyid, $resourceid));
        } else {
            return $this->getResponse()->setStatusCode(403);
        }
    }
    
    /**
     * This action aims to insert a new resource to a hierarchy.
     * It uses details provided by POST parameters and returns the ID
     * of the new resource as generated by MySQL (autoincrement index).
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function addResourceAction() {
        if ($this->getRequest()->isPost() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'add_resource')) {
            /**
             * TODO
             *      - Validate POST data
             *        (http://stackoverflow.com/questions/458299/handling-input-with-the-zend-framework-post-get-etc#answer-458312)
             *      - Filter POST data
             */
            $hierarchyid = $this->params()->fromRoute('id');
            $parentId = $this->params()->fromPost('parentId');
            $resourceName = $this->params()->fromPost('resourceName');
            $resourceDescription = $this->params()->fromPost('resourceDescription');
            $resourceType = $this->params()->fromPost('resourceType');
            $resourceBookable = $this->params()->fromPost('resourceBookable');
            //$resourceColor = ($validator->isValid($this->params()->fromPost('resourceColor')) ? $this->params()->fromPost('resourceColor') : null);
            
            $resourceEntity = new ContainmentEntity();
            $resourceEntity->seth_hierarchyid($hierarchyid);
            $resourceEntity->setc_hierarchyid($hierarchyid);
            $resourceEntity->setc_parent($parentId);
            $resourceEntity->setr_name($resourceName);
            $resourceEntity->setr_description($resourceDescription);
            $resourceEntity->setr_isbookable($resourceBookable);
            //$resourceEntity->setr_color($resourceColor);
            

           try {
               /*
                * Maybe devide insertResource() function into separate function for resourceType
                */
               $resourceId = $this->resourceMapper->insertResource($resourceEntity, $resourceType);
               $this->logger()->insert(0, 'Resource::insert: A new Resource titled "'. $resourceEntity->getr_name() .'" has been created.', $this->userAuthentication()->getIdentity(), null, $resourceId);
           } catch (\Exception $e) {
               $this->logger()->insert(2, 'Resource::insert error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
               $resourceId = null;
           }
           
           if(is_int($resourceId)) {
               return new JsonModel(array(
               		'resourceid' => $resourceId,
               		'success' => true
               ));
           } else {
               return new JsonModel(array(
               		'resourceid' => null,
               		'success' => false
               ));
           } 
        } else {
            return $this->getResponse()->setStatusCode(403);
        }
    }

    /**
     * This action aims to update the information of a resource through a
     * POST request and returns a JsonModel indicatin wheter the update
     * was successful.
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function editResourceAction() {
    	/*
    	 * TODO Validate?
    	*/
    	if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'edit_resource')) {
    		$hierarchyId = $this->params()->fromRoute('id');
    		$resourceId = $this->params()->fromRoute('rid');
    		$resourceName = $this->params()->fromPost('resourceName');
    		$resourceDescription = $this->params()->fromPost('resourceDescription');
    		$resourceType = $this->params()->fromPost('resourceType');
    		$resourceBookable = $this->params()->fromPost('resourceBookable');
           // $resourceColor = ($validator->isValid($this->params()->fromPost('resourceColor')) ? $this->params()->fromPost('resourceColor') : null);
    		
            $resourceEntity = new ContainmentEntity();
            $resourceEntity->seth_hierarchyid($hierarchyId);
            $resourceEntity->setc_hierarchyid($hierarchyId);
            $resourceEntity->setr_resourceid($resourceId);
            $resourceEntity->setr_name($resourceName);
            $resourceEntity->setr_description($resourceDescription);
            $resourceEntity->setr_isbookable($resourceBookable);
           // $resourceEntity->setr_color($resourceColor);
            

            try {
               /*
                * Maybe devide inserResource() function into separate function for resourceType
                */
               $rslt = $this->resourceMapper->editResource($resourceEntity, $resourceType);
               $this->logger()->insert(0, 'Resource::edit: Resource #'.$resourceId.' has been edited.', $this->userAuthentication()->getIdentity(), null, $resourceId);
            } catch (\Exception $e) {
               $this->logger()->insert(2, 'Resource::edit error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
               $rslt = false;
            }
            
            return new JsonModel(array(
            	'success' => $rslt
            ));
    	} else {
    		return $this->getResponse()->setStatusCode(403);
    	}
    }
	
    /**
     * This action aims to delete a resource from the tree and returns
     * a success flag for the front-end.
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteResourceAction() {
        if ($this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'delete_resource')) {
        	/*
        	 * TODO Validate?
        	 */
            
            $hierarchyId = (int) $this->params()->fromRoute('id');
            $resourceId = (int) $this->params()->fromRoute('rid');
            try {
                $rlst = $this->resourceMapper->deleteResourceById($resourceId);
            } catch(\Exception $e) {
                $this->logger()->insert(2, 'Resource::delete error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
                $rslt = false;
            }
                    
        	/*
        	 * TODO return true/false
        	 */
            return new JsonModel(array(
                'success' => $rlst
            ));
        } else {
            return $this->getResponse()->setStatusCode(403);
        }
    }

    /**
     * This action aims to update the position of a resource through a
     * POST request and returns a JsonModel indicatin wheter the update
     * was successful.
     *
     * @return \Zend\View\Model\JsonModel
     */
    public function updateResourceAction() {
        /*
         * TODO Validate?
         */
        if ($this->getRequest()->isPost() && $this->getRequest()->isXmlHttpRequest() && $this->acl()->isAllowed($this->userAuthentication()->getRole(), 'edit_resource')) {
            $hierarchyId = (int) $this->params()->fromRoute('id');
            $resourceId = (int) $this->params()->fromRoute('rid');
            $newParentId = (int) $this->params()->fromPost('newParentId');
            

            // TODO
            try {
                $rslt = $this->resourceMapper->updatePosition($resourceId, $newParentId);
                $this->logger()->insert(0, 'Resource::update: Position has been updated.', $this->userAuthentication()->getIdentity(), null, $resourceId);
                
            } catch (\Exception $e) {
                $this->logger()->insert(2, 'Resource::update error: '. $e->getMessage(), $this->userAuthentication()->getIdentity());
                $rslt = false;
            }
            /*
             * TODO return true/false
            */
            return new JsonModel(array(
            		'success' => $rslt
            ));
        } else {
            return $this->getResponse()->setStatusCode(403);
        }
    }
}