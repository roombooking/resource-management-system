<?php
namespace Application\Entity;

class Role
{
    protected $roleid = 0;
    protected $name = '';
    
    public function setRoleid($roleid) {
        $this->roleid = $roleid;
    }
    
    public function getRoleid() {
        return $this->roleid;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
}