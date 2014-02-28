<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
    
    
    public function __construct($powerMapper, $roleMapper)
    {
    	$this->powerMapper = $powerMapper;
    	$this->roleMapper = $roleMapper;
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