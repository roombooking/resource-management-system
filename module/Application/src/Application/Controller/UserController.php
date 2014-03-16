<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

/**
 * UserController
 * 
 * The user controller contains logic to read and modify users and
 * to read roles.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */
class UserController extends AbstractActionController
{
    /**
     * @var Application\Mapper\User
     */
    private $userMapper;
    
    /**
     * @var Application\Mapper\Role
     */
    private $roleMapper;
    
    /**
     * 
     * @param Application\Mapper\User $userMapper
     * @param Application\Mapper\Role $roleMapper
     */
    public function __construct($userMapper, $roleMapper)
    {
        $this->userMapper = $userMapper;
        $this->roleMapper = $roleMapper;
    } 
    
    /**
     * This action provides an overview over all exisiting users
     * in the database and their roles.
     * 
     * (non-PHPdoc)
     * @see \Zend\Mvc\Controller\AbstractActionController::indexAction()
     */
    public function indexAction ()
    {
        /*
         * TODO prepare pagination
         */
        $users = $this->userMapper->fetchAll();
        $roles = $this->roleMapper->fetchAll();
        return new ViewModel(array(
        	   'users' => $users,
               'roles' => $roles, 
        ));
    }
    
    /**
     * The edit action provides a JsonModel, allowing any view
     * to assign new roles to users with an AJAX request.
     * 
     * It returns the id of the updated user along with her/his
     * role in case it is called by a XmlHttpRequest or redirects
     * to the user route in case it is called in a different manner.
     * 
     * @return \Zend\View\Model\JsonModel | NULL
     */
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
    
    /**
     * This action should synchronize the local database
     * with the LDAP database.
     * 
     * TODO implement this
     * 
     * @throws \Exception
     */
    public function refreshAction ()
    {
        throw new \Exception("Not implemented yet.");
    }
}