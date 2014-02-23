<?php
namespace Application\Entity;

class Role
{
    protected $id = 0;
    protected $name = '';
    
    public function setId($roleid) {
        $this->id = $roleid;
    }
    
    public function getId() {
        return $this->id;
    }
    
    public function setName($name) {
        $this->name = $name;
    }
    
    public function getName() {
        return $this->name;
    }
}