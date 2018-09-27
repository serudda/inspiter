<?php
class Role
{
 private $roleId;
 private $roleUser;
 private $name;
 private $description;
 
 public function Role($roleId,$roleUser,$name,$description)
 {
  $this->roleId = $roleId;
  $this->roleUser = $roleUser;
  $this->name = $name;
  $this->description = $description;
 }
 
 //getter
 public function getRoleId()
 {return $this->roleId;}
 
 public function getRoleUser()
 {return $this->roleUser;}
 
 public function getName()
 {return $this->name;}
 
 public function getDescription()
 {return $this->description;}
 
 //setter
 public function setRoleId($roleId)
 {$this->roleId = $roleId;}
  
 public function setRoleUser($roleUser)
  {$this->roleUser = $roleUser;}
  
 public function setName($name)
 {$this->name = $name;}
  
 public function setDescription($description)
  {$this->description = $description;}
}

?>