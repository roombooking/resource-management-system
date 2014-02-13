<?php
namespace Application\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

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
 
    public function __construct($userMapper
    )
    {
        $this->userMapper = $userMapper;
    } 
    
    /**
     * The default action - show the home page
     */
    public function indexAction ()
    {
        // TODO Auto-generated UserController::indexAction() default action
        return new ViewModel();
    }
    
    public function editAction ()
    {
    	return new ViewModel();
    }
    
    public function refreshAction ()
    {
    	return new ViewModel();
    }
}