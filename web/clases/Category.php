<?php
class Category
{
 protected $categoryId;
 protected $name;
 protected $description;
 
 public function Category($categoryId,$name,$description)
 {
  $this->categoryId = $categoryId;
  $this->name = $name;
  $this->description = $description;
 }
 
 //getter
 public function getCategoryId()
 {return $this->categoryId;}
 
 public function getName()
 {return $this->name;}
 
 public function getDescription()
 {return $this->description;}
 
 //setter
 public function setCategoryId($categoryId)
 {$this->categoryId = $categoryId;}
  
 public function setName($name)
 {$this->name = $name;}
  
 public function setDescription($description)
  {$this->description = $description;}
}

?>