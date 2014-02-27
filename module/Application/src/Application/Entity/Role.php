<?php
namespace Application\Entity;

class Role
{
    protected $roleid = 0;
    protected $rolename = '';
    
    public function setId($roleid) {
        $this->roleid = $roleid;
    }
    
    public function getId() {
        return $this->roleid;
    }
    
    public function setName($name) {
        $this->rolename = $name;
    }
    
    public function getName() {
        return $this->rolename;
    }
}