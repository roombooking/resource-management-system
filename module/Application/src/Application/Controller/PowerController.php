<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\Power;
use Application\Entity\Power as PowerEntity;

/**
 * PowerController
 * 
 * The power controller contains logic to read and modify powers and
 * roles.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class PowerController extends AbstractActionController
{
    /**
     * @var Application\Mapper\Power
     */
    private $powerMapper;
    
    /**
     * @var Application\Mapper\Role
     */
    private $roleMapper;
    
    /**
     * @var Application\Form\Power
     */
    private $powerForm;
    
    /**
     * @var array
     */
    private $roles = array();
    
    
    
    /**
     * The power constructor is provided with mappers for
     * powers and roles and the form that is used to edit powers.
     * 
     * @param Application\Mapper\Power $powerMapper
     * @param Application\Mapper\Role $roleMapper
     * @param Application\Form\Power $powerForm
     */
    public function __construct($powerMapper, $roleMapper, $powerForm)
    {
    	$this->powerMapper = $powerMapper;
    	$this->roleMapper  = $roleMapper;
    	$this->powerForm   = $powerForm;
    	
    	$rolesObj = $this->roleMapper->fetchAll();
    	foreach ($rolesObj as $role) :
    	   $this->roles[$role->getId()] = $role->getName();
    	endforeach;
    	$this->powerForm->get('roleid')->setValueOptions($this->roles);
    }
    
    /**
     * The default action provides over users and their roles/powers.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function overviewAction()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'show_power_list')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
    	$powers = $this->powerMapper->fetchAll(true);
    	    	
    	return new ViewModel(array(
    			'powers' => $powers,
    			'roles' => $this->roles,
    	));
    }
    
    /**
     * The add action allows an administrator to map existing roles
     * with modules/controllers/actions.
     * 
     * It is the administrative front-end to user authorisation paradigm
     * used in this application.
     * 
     * @return \Zend\View\Model\ViewModel
     */
    public function addAction()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'add_power')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        $this->powerForm->setAttribute('action', '/powers/add');
        
        $this->powerForm->get('roleid')->setEmptyOption(
        		array(
        				'label' => 'Please choose the role',
        				'disabled' => true,
        				'selected' => true
        		)
        );
        
    	if($this->getRequest()->isPost()) {
    	    $this->powerForm->setData($this->getRequest()->getPost());
    	    	
        
        	if($this->powerForm->isValid()) {
        		$powerEntity = $this->powerForm->getData();
        		$powerEntity->setModule('%');
        		$powerEntity->setController('%');
        		
        		
        		$this->powerMapper->insert($powerEntity);
        		$this->logger()->insert(0, 'Power::add: New Power (ID: # '.$this->powerMapper->getLastInsertValue().') has been added ('.$this->roles[$powerEntity->getRoleId()].'/'.$powerEntity->getModule().'/'.$powerEntity->getController().'/'.$powerEntity->getAction().')', $this->userAuthentication()->getIdentity());
        		/*
        		 * Redirect to home page
        		*/
        		return $this->redirect()->toRoute('power');
        		//$this->stopPropagation();
        	} else {
        		return new ViewModel(
        				array(
        						'form' => $this->powerForm,
        				        'loginError' => true
        				)
        		);
        	}
        } else {
    		return new ViewModel(array(
    			    'form' => $this->powerForm,
    		        'loginError' => false
    		));
    	}
    }
    
    /**
     * 
     * @return \Application\Controller\JsonModel
     */
    public function editAction()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'edit_power')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        $powerId = $this->getEvent()->getRouteMatch()->getParam('id');
        
        if($this->getRequest()->isPost()) {
    	    $this->powerForm->setData($this->getRequest()->getPost());
        
        	if($this->powerForm->isValid()) {
        		$powerEntity = $this->powerForm->getData();
        		$powerEntity->setPowerId($powerId);
        		$powerEntity->setModule('%');
        		$powerEntity->setController('%');
                
        		$this->powerMapper->updateEntity($powerEntity);
        		$this->logger()->insert(0, 'Power::edit: Power (ID: # '.$this->powerMapper->getLastInsertValue().') has been edited ('.$this->roles[$powerEntity->getRoleId()].'/'.$powerEntity->getModule().'/'.$powerEntity->getController().'/'.$powerEntity->getAction().')', $this->userAuthentication()->getIdentity());
        		/*
        		 * Redirect to home page
        		*/
        		return $this->redirect()->toRoute('power');
        		//$this->stopPropagation();
        	} else {
        		return $this->redirect()->toRoute('power/powerEdit', array('id' => $powerId));
        	}
        } else {
            
            $powerEntity = $this->powerMapper->getId($powerId);
            if($powerEntity->current() == null) {
                throw new \Exception('PowerID unknown');
            } else {
                $powerEntity = $powerEntity->current();
            }
            
            $this->powerForm->setAttribute('action', '/powers/edit/' . $powerId);
            $this->powerForm->get('submit')->setValue('Edit Power');           
             
            $this->powerForm->get('module')->setValue($powerEntity->getModule());
            $this->powerForm->get('controller')->setValue($powerEntity->getController());
            $this->powerForm->get('action')->setValue($powerEntity->getAction());
            $this->powerForm->get('roleid')->setValue($powerEntity->getRoleId());
            
            $viewModel = new ViewModel(array(
    			    'form' => $this->powerForm, 
    		));
            $viewModel->setTemplate('application/power/add.phtml');
            
            return $viewModel;
    	}
    }
    
    /**
     * 
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:number NULL
     */
    public function deleteAction()
    {
        if(!$this->acl()->isAllowed($this->userAuthentication()->getRole(), 'delete_power')) {
        	$this->getResponse()->getContent(403);
        	throw new \Exception('Insufficient rights!');
        }
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $this->powerMapper->deletePowerById($id);
        }
        return $this->redirect()->toRoute('power');
        //$this->stopPropagation();
    }
}