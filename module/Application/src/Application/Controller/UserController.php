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
            $this->userMapper->update(array('roleid' => $data['role']), array('userid' => $data['id'] ));
            $this->logger()->insert(0, 'User::edit: User (ID: #'.$data['id'].') has been awarded to role: ID #'.$data['role'], $this->userAuthentication()->getIdentity());
            
            return new JsonModel(array(
                    'id' => $data['id'],
                    'role' => $data['role'] 
            ));
        } else {
            return $this->redirect()->toRoute('user');
        }
    }
    
    /**
     * This action should synchronize the local database
     * with the LDAP database.
     * 
     * TODO implement this
     *  
     */
    public function refreshAction ()
    {
        // user authenticated, now update everything
        // LDAP check: get LDAP user information
        $ldap_adapter =  $this->userAuthentication()->getAuthService()->getAdapter();
        $multiOptions = $ldap_adapter->getOptions();
        $ldap = $ldap_adapter->getLdap();
        
        
        foreach ($multiOptions as $name => $options) {
            // echo "Trying to bind using server options for '$name'\n";
            $ldap->setOptions($options);
            try {
                $ldap->bind();
                //echo "SUCCESS: authenticated $acctname\n";
                break;
            } catch (\Zend\Ldap\Exception\LdapException $zle) {
                // echo '  ' . $zle->getMessage() . "\n";
            	if ($zle->getCode() === \Zend\Ldap\Exception\LdapException::LDAP_X_DOMAIN_MISMATCH) {
            	   continue;
                }
            }
        }
        
        if($ldap->getBoundUser() === false || is_null($ldap->getBoundUser())) {
            $this->logger()->insert(2, 'User::refresh error: No LDAP connection', $this->userAuthentication()->getIdentity());
            throw new \Exception('No LDAP connection!');
        } else {
            $users = $this->userMapper->fetchAll();
            $ldapBaseDn = $ldap->getBaseDn();
            
            foreach ($users as $user) {
                $objectClass    = \Zend\Ldap\Filter::any('objectClass');
                $uidnumber      = \Zend\Ldap\Filter::equals('uidnumber', $user->getLdapId()); 
                
                $filter         = \Zend\Ldap\Filter::andFilter($objectClass, $uidnumber);
                                
       	
            	$ldapEntries    = $ldap->search($filter, $ldapBaseDn, \Zend\Ldap\Ldap::SEARCH_SCOPE_ONE, array('givenname', 'sn', 'mail', 'uid'));
            	$count          = $ldapEntries->count();
            	if ($count === 1) {
            		$ldapEntry = $ldapEntries->getFirst();
            		$ldapEntries->close();
            		
            		$user->setIsDeleted(false);
            		$user->setLoginName($ldapEntry['uid'][0]);
            		$user->setFirstName($ldapEntry['givenname'][0]);
            		$user->setLastName($ldapEntry['sn'][0]);
            		if(isset($ldapEntry['mail']))
            		    $user->setEmail($ldapEntry['mail'][0]);
            		

            		$this->userMapper->updateEntity($user);
            	} else {
            		if ($count === 0) {
            			$code = \Zend\Ldap\Exception\LdapException::LDAP_NO_SUCH_OBJECT;
            			$str  = "No object found for: $filter";
            			
            			$user->setIsDeleted(true);
            			$this->userMapper->updateEntity($user);
            			$this->logger()->insert(0, 'User::refresh: ' . $str . '. User has been marked as deleted.', $this->userAuthentication()->getIdentity());
            		} else {
            			$code = \Zend\Ldap\Exception\LdapException::LDAP_OPERATIONS_ERROR;
            			$str  = "Unexpected result count ($count) for: $filter";
            			$this->logger()->insert(2, 'User::refresh: ' . $str, $this->userAuthentication()->getIdentity());
            		}
            	}
            	$ldapEntries->close();
            }
            $this->logger()->insert(0, 'User::refresh: the user database has been updated.', $this->userAuthentication()->getIdentity());
        }
        
        return $this->redirect()->toRoute('user');;
    }
}