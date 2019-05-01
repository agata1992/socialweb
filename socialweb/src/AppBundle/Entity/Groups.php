<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups")
 */
 
class Groups
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	*/
	private $id;
	
	/**
	* @ORM\Column(name="owner_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $owner_id;
	
	/**
	* @ORM\Column(name="title",type="string",length=50)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $title;
	
	/**
	* @ORM\Column(name="description",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $description;
	
	/**
	* @ORM\Column(name="category",type="string",length=100)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $category;
	
	/**
	* @ORM\Column(name="type",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $type;
	
	/**
	* @ORM\Column(name="add_date",type="date")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $add_date;
	
	/**
	* @ORM\Column(name="image",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $image;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getowner_id()
	{
		return $this->owner_id;
	}
	
	public function gettitle()
	{
		return $this->title;
	}
	
	public function getdescription()
	{
		return $this->description;
	}
	
	public function getcategory()
	{
		return $this->category;
	}
	
	public function gettype()
	{
		return $this->type;
	}
	
	public function getadd_date()
	{
		return $this->add_date;
	}
	
	public function getimage()
	{
		return $this->image;
	}
		
	public function setowner_id($owner_id)
	{
		$this->owner_id = $owner_id;
	}	
		
	public function settitle($title)
	{
		$this->title = $title;
	}
	
	public function setdescription($description)
	{
		$this->description = $description;
	}
	
	public function setcategory($category)
	{
		$this->category = $category;
	}
	
	public function settype($type)
	{
		$this->type = $type;
	}
	
	public function setadd_date($add_date)
	{
		$this->add_date = $add_date;
	}
	
	public function setimage($image)
	{
		$this->image = $image;
	}
}