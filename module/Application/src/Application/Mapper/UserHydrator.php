<?php
namespace Application\Mapper;

use Zend\Stdlib\Hydrator\Reflection;
use Application\Entity\User as UserEntity;
use Application\Mapper\Role as RoleTable;

class UserHydrator extends Reflection
{
    public function hydrate($data, $object) {
        if(!$object instanceof UserEntity) {
            throw new \InvalidArgumentException('$object must be an instance of Application\Entity\User');
        }
        
        $data = $this->mapField('roleid','role', $data);
        return parent::hydrate($data, $object);
    }
    
    public function extract($object) {
    	if (!$object instanceof UserEntity) { throw new \InvalidArgumentException(
    			'$object must be an instance of Application\Entity\User'
    	); }
    	$data = parent::extract($object);
    	$data = $this->mapField('role', 'roleid', $data); return $data;
    }
    
    protected function mapField($keyFrom, $keyTo, array $array) {
        $array[$keyTo] = $array[$keyFrom];
        unset($array[$keyFrom]);
        return $array;
    }
}

?>