<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class AuthController extends AbstractActionController
{
    private $loginForm;
    private $authService;    
    
    //TODO: aufsplitten auf checkAction()
    public function loginAction()
    {
        $this->layout('layout/login');
        if(!$this->loginForm) {
        	throw new \BadMethodCallException('Login Form not yet set!');
        }
        if(!$this->authService) {
        	throw new \BadFunctionCallException('Auth Service not yet set!');
        }
        
        if($this->authService->hasIdentity()) {
            return new ViewModel(
            		array(
            				'loginSuccess' => true,
            				'userLoggedIn' => $this->authService->getIdentity()
            		)
            );
        } elseif($this->getRequest()->isPost())
        {
        	$this->loginForm->setData($this->getRequest()->getPost());
        
        	if($this->loginForm->isValid()) {
        		$data = $this->loginForm->getData();
                $ldapAdapter = $this->authService->getAdapter();
        		$ldapAdapter->setIdentity($data['username']);
        		$ldapAdapter->setCredential($data['password']);
        		
        		$authResult = $this->authService->authenticate();
        
        		if(!$authResult->isValid())
        		{
        			return new ViewModel(
        					array(
        							'form' => $this->loginForm,
        							'loginError' => true
        					)
        			);
        		} else {
        		    
        		    
        			return new ViewModel(
        					array(
        							'loginSuccess' => true,
        							'userLoggedIn' => $authResult->getIdentity()
        					)
        			);
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
    
    //FIXME: unused
    public function checkAction() {
        if(!$this->loginForm) {
        	throw new \BadMethodCallException('Login Form not yet set!');
        }
        if(!$this->authService) {
        	throw new \BadFunctionCallException('Auth Service not yet set!');
        }

        if($this->getRequest()->isPost())
        {
        	$this->loginForm->setData($this->getRequest()->getPost());
        
        	if($this->loginForm->isValid()) {
        		$data = $this->loginForm->getData();
                
        		$this->authService->getAdapter()->setIdentity($data['username']);
        		$this->authService->getAdapter()->setCredential($data['password']);
        
        		$authResult = $this->authService->authenticate();
        
        		if(!$authResult->isValid())
        		{
        			return new ViewModel(
        					array(
        							'form' => $this->loginForm,
        							'loginError' => true
        					)
        			);
        		} else {
        			return new ViewModel(
        					array(
        							'loginSuccess' => true,
        							'userLoggedIn' => $authResult->getIdentity()
        					)
        			);
        		}
        	} else {
        		$this->redirect()->toRoute('login');
        	}
        } else {
            $this->redirect()->toRoute('login');
        }
    }
    
    public function logoutAction() {
        if(!$this->authService) {
        	throw new \BadFunctionCallException('Auth Service not yet set!');
        }
        if($this->authService->hasIdentity()) {
            $this->authService->clearIdentity();
        }
        
        $this->redirect()->toRoute('login');
    }
    
    public function setLoginForm($loginForm) {
    	$this->loginForm = $loginForm;
    }
    
    public function getLoginForm() {
    	return $this->loginForm;
    }
    
    public function setAuthService($authService) {
    	$this->authService = $authService;
    }
    
    public function getAuthService() {
    	return $this->authService;
    }
}
