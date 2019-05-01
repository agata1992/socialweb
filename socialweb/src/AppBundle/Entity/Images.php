<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="images")
 */
class Images
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;
	
	/**
	* @ORM\Column(name="album_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $album_id;
	
	/**
	* @ORM\Column(name="image_name",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $image_name;
	
	/**
	* @ORM\Column(name="description",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $description;
	
	/**
	* @ORM\Column(name="add_date",type="date")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $add_date;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getalbum_id()
	{
		return $this->album_id;
	}
	
	public function getimage_name()
	{
		return $this->image_name;
	}
	
	public function getdescription()
	{
		return $this->description;
	}
	
	public function getadd_date()
	{
		return $this->add_date;
	}
	
	public function setalbum_id($album_id)
	{
		$this->album_id = $album_id;
	}
	
	public function setimage_name($image_name)
	{
		$this->image_name = $image_name;
	}
	
	public function setdescription($description)
	{
		$this->description = $description;
	}
	
	public function setadd_date($add_date)
	{
		$this->add_date = $add_date;
	}
}