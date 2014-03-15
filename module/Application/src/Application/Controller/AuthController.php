<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User as UserEntity;


class AuthController extends AbstractActionController
{
    private $loginForm;
    private $userMapper;

    public function __construct($userMapper, $loginForm)
    {
    	$this->userMapper  = $userMapper;
    	$this->loginForm   = $loginForm;
    }
    
    //TODO: aufsplitten auf checkAction()
    public function loginAction()
    {
        // User already logged in -> redirect
        if($this->userAuthentication()->hasIdentity()) {
            return $this->redirect()->toRoute('home');
            // $this->stopPropagation();
        } else {
            // check if the form is submitted
            if($this->getRequest()->isPost())
            {
            	$this->loginForm->setData($this->getRequest()->getPost());
                
            	//check if the form is valid
            	if($this->loginForm->isValid()) {
            		$data = $this->loginForm->getData();
                    $ldapAdapter = $this->userAuthentication()->getAuthService()->getAdapter();
            		$ldapAdapter->setIdentity($data['username']);
            		$ldapAdapter->setCredential($data['password']);
            		
            		$authResult = $this->userAuthentication()->getAuthService()->authenticate();
            		
            		// wrong credentials
            		if(!$authResult->isValid())
            		{
            			return new ViewModel(
            					array(
            							'form' => $this->loginForm,
            							'loginError' => true
            					)
            			);
            		} else {
            		    // user authenticated, now update everything
            		    // LDAP check: get LDAP user information
            		    $ldap = $ldapAdapter->getLdap();
            		    $ldapEntry = $ldap->getEntry($ldap->getCanonicalAccountName($this->userAuthentication()->getIdentity(), \Zend\Ldap\Ldap::ACCTNAME_FORM_DN));
            		    
            		    $ldapUser = new UserEntity();
            		    $ldapUser->setLdapId($ldapEntry['uidnumber'][0]);
            		    $ldapUser->setLoginName($data['username']);
            		    //FIXME: role should not be hard coded
            		    $ldapUser->setRole(3);
            		    $ldapUser->setEmail($ldapEntry['mail'][0]);
            		    $ldapUser->setFirstName($ldapEntry['givenname'][0]);
            		    $ldapUser->setLastName($ldapEntry['sn'][0]);
            		    
            		    // check if the user exist
            		    try {
            		        //TODO: check if there are changes
            		    	$user = $this->userMapper->fetchLdapId($ldapUser->getLdapId());
                            $user->setLoginName($ldapUser->getLoginName());
                            $user->setEmail($ldapUser->getEmail());
                            $user->setFirstName($ldapUser->getFirstName());
                            $user->setLastName($ldapUser->getLastName());
                            
                            $this->userMapper->updateEntity($user);
                            $this->userAuthentication()->getAuthService()->getStorage()->write((int) $user->getId());
                            //TODO: Log Userupdate
            		    	
            		    } catch (\Exception $e) {
            		        //if an error is thrown, the user does not exist and should be inserted
            		        $this->userMapper->insert($ldapUser);
            		        $this->userAuthentication()->getAuthService()->getStorage()->write((int) $this->userMapper->getLastInsertValue());
            		        //TODO: Log User Insert
            		    }
            		    
            		    //TODO: Hard kodierte User mit alle rechten ausstatten.
            		    
            		    //TODO: Log updaten?!
            		    return $this->redirect()->toRoute('home');
                        //$this->stopPropagation();
            		}
            	} else {
            		return new ViewModel(
            				array(
            						'form' => $this->loginForm,
            				        'loginError' => true
            				)
            		);
            	}
            } else {
                return new ViewModel(
                		array(
                				'form' => $this->loginForm,
                		)
                );
            }
        }
    }
    
    public function logoutAction() {
        if($this->userAuthentication()->hasIdentity()) {
            $this->userAuthentication()->getAuthService()->clearIdentity();
        }
        
        return $this->redirect()->toRoute('login');
    }
}
