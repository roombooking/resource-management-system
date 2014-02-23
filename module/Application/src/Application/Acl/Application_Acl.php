<?php
namespace Application\Acl;

class Application_Acl
{
    private $adapter;
    
    public function __construct($_adapter) {
        $this->adapter = $_adapter;
    }
    
    public function isAllowed($user = null, $request = null, $privilege = null)
    {
        if (is_null($user) === false && $user !== false && $user instanceof User) {
            $userId = $user->id;
        } else {
            $userId = 0;
        }
        $db = Zend_Db_Table::getDefaultAdapter(); $stmt = $db->query('
                    select
                       module_name,
                       controller_name,
                       action_name
                    from
                        privilege
                              join role
                                      on role.id = privilege.role_id
                              join userRole
                                      on userRole.role_id = role.role_id
                    where
                        userRole.user_id = ?
                        and
                        (
                            module_name = "%"
                            or
                            (
                                module_name = ?
        and (
                controller_name = "%"
        or
        (
            controller_name = ?
            and
            (
                action_name = "%"
                or
                action_name = ?
        ￼￼)) )
        ))
        ', array(
        
                $userId,
                $request->getModuleName(),
                $request->getControllerName(),
                $request->getActionName()
                ) );
        
        $stmt->execute();
        $row = $stmt->fetch(); // Returns a row or false
        if ($row !== false) {
        return true; } else {
        return false; }
    }
}