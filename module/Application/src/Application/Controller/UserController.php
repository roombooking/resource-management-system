<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * UserController
 *
 * @author
 *
 * @version
 *
 */
class UserController extends AbstractActionController
{
    /**
     * @var Application\Mapper\User
     */
    private $userMapper;
    
    /**
     * @var Application\Mapper\User
     */
    private $roleMapper;
    
 
    public function __construct($userMapper, $roleMapper)
    {
        $this->userMapper = $userMapper;
        $this->roleMapper = $roleMapper;
    } 
    
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        $users = $this->userMapper->fetchAll();
        $roles = $this->roleMapper->fetchAll();
        return new ViewModel(array(
        	   'users' => $users,
               'roles' => $roles, 
        ));
    }
    
    public function editAction()
    {
        if($this->getRequest()->isXmlHttpRequest()) {
            $data = $this->getRequest()->getPost();
            //$updateEntity = new User();
            //$updateEntity->setId($data['id']);
            //$updateEntity->setRole($data['role']);
            //$status = $this->userMapper->updateEntity($updateEntity);
            $this->userMapper->update(array('roleid' => $data['role']), array('userid' => $data['id'] ));
            return new JsonModel(array(
                    'id' => $data['id'],
                    'role' => $data['role'] 
            ));
        } else {
            $this->redirect()->toRoute('user');
        }
    }
    
    public function refreshAction ()
    {
    	return new ViewModel();
    }
}