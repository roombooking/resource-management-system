<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Form\Power;
/**
 * PowerController
 *
 * @author
 *
 * @version
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
    
    
    public function __construct($powerMapper, $roleMapper, $powerForm)
    {
    	$this->powerMapper = $powerMapper;
    	$this->roleMapper  = $roleMapper;
    	$this->powerForm   = $powerForm;
    }
    
    /**
     * The default action - show the home page
     */
    public function overviewAction()
    {
    	$powers = $this->powerMapper->fetchAll();
    	$roles = $this->roleMapper->fetchAll();
    	return new ViewModel(array(
    			'powers' => $powers,
    			'roles' => $roles,
    	));
    }

    public function addAction()
    {
        $this->powerForm->setAttribute('action', '/powers/add');
        
        $roles = $this->roleMapper->select();
        $fieldElements = array();
        
        foreach ($roles as $role) { 
            $fieldElements[$role['roleid']] = $role['rolename'];
        }
        $this->powerForm->get('roleid')->setValueOptions($fieldElements);
        $this->powerForm->get('roleid')->setEmptyOption(array('empty_option' => array(
                                'label' => 'Please choose the role',
                                'disabled' => true,
                                'selected' => true
                         )));
        
    	if($this->getRequest()->isPost()) {
    	    $this->powerForm->setData($this->getRequest()->getPost());
        
        	if($this->powerForm->isValid()) {
        		$data = $this->powerForm->getData();
                
        		
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
    		));
    	}
    }
    
    public function editAction()
    {
        $this->powerForm->setAttribute('action', '/powers/edit');
        
        $roles = $this->roleMapper->select();
        $fieldElements = array();
        
        foreach ($roles as $role) {
        	$fieldElements[$role['roleid']] = $role['rolename'];
        }
        $this->powerForm->get('roleid')->setValueOptions($fieldElements);
        
    	if($this->getRequest()->isXmlHttpRequest()) {
    		$data = $this->getRequest()->getPost();
    		//$updateEntity = new User();
    		//$updateEntity->setId($data['id']);
    		//$updateEntity->setRole($data['role']);
    		//$status = $this->userMapper->updateEntity($updateEntity);
    		$this->userMapper->update(array('roleid' => $data['role']), array('powerid' => $data['id'] ));
    		return new JsonModel(array(
    				'id' => $data['id'],
    				'role' => $data['role']
    		));
    	} elseif($this->getRequest()->isPost()) {
    	    $data = $this->getRequest()->getPost();
    	} else {
    		$this->redirect()->toRoute('power');
    	}
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('power');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');
            
            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }
            
            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }
        
        return array(
            'id'    => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }
}