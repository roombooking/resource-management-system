<?php
namespace Application\Entity;

/**
 * Hierarchy Entity
 *
 * This entity represents a hierarchy.
 *
 * The naming follows the database structure. The attributes are named
 * in the following fashion: {firstLetterOfTable}_{attributeName} to
 * prevent ambiguous names on joined tables.
 *
 * @author Roombooking Study Project (see AUTHORS.md)
 *
 * @version 0.1
 *
 */

class Hierarchy {
// SELECT
//      h.hierarchyid AS h_hierarchyid,
//      h.name AS h_name
// FROM
//      Hierarchies h
    
    protected $h_hierarchyid;
    protected $h_name;
    
    /**
    * Sets h_hierarchyid
    *
    * @param type $h_hierarchyid
    * @return void
    */
    public function seth_hierarchyid($h_hierarchyid)
    {
            $this->h_hierarchyid = $h_hierarchyid;
    }
    
    /**
    * Gets h_hierarchyid
    *
    * @return type
    */
    public function geth_hierarchyid()
    {
            return $this->h_hierarchyid;
    }
    
    /**
    * Sets h_name
    *
    * @param type $h_name
    * @return void
    */
    public function seth_name($h_name)
    {
            $this->h_name = $h_name;
    }
    
    /**
    * Gets h_name
    *
    * @return type
    */
    public function geth_name()
    {
            return $this->h_name;
    }
}
?>