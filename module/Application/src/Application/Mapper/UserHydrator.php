<?php
namespace Application\Mapper;

use Zend\Stdlib\Hydrator\Reflection;
use Application\Entity\User;

class UserHydrator extends Reflection
{
    public function hydrate($data, $object) {
        if(!$object instanceof User) {
            throw new \InvalidArgumentException('$object must be an instance of Application\Entity\User');
        }
        
//         $data = $this->mapField('','', $data);
        return parent::hydrate($data, $object);
    }
    
    protected function mapField($keyFrom, $keyTo, array $array) {
        $array[$keyTo] = $array[$keyFrom];
        unset($array[$keyFrom]);
        return $array;
    }
}

?>