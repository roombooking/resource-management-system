<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Roombooking for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Roombooking\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class RoombookingController extends AbstractActionController
{
    public function indexAction()
    {
        return array();
    }

    public function fooAction()
    {
        // This shows the :controller and :action parameters in default route
        // are working when you browse to /roombooking/roombooking/foo
        return array();
    }
}
