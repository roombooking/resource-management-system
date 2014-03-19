<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Form\Power;

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
    }
    
    /**
     * The default action provides over users and their roles/powers.
     * 
     * @return \Zend\View\Model\ViewModel
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
        $this->powerForm->setAttribute('action', '/powers/add');
        
        $roles = $this->roleMapper->select();
        $fieldElements = array();
        
        foreach ($roles as $role) { 
            $fieldElements[$role['roleid']] = $role['rolename'];
        }
        $this->powerForm->get('roleid')->setValueOptions($fieldElements);
        $this->powerForm->get('roleid')->setEmptyOption(
                array('empty_option' => array(
                    'label' => 'Please choose the role',
                    'disabled' => true,
                    'selected' => true
                ))
        );
        
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
    
    /**
     * 
     * @return \Application\Controller\JsonModel
     */
    public function editAction()
    {
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
    	} else {
    		$this->redirect()->toRoute('power');
    	}
    }
    
    /**
     * 
     * @return Ambigous <\Zend\Http\Response, \Zend\Stdlib\ResponseInterface>|multitype:number NULL
     */
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