<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="image_comments")
 */
 
class Image_Comments
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	*/
	private $id;
	
	/**
	* @ORM\Column(name="user_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $user_id;
	
	/**
	* @ORM\Column(name="image_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $image_id;
	
	/**
	* @ORM\Column(name="add_date",type="datetime")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $add_date;
	
	/**
	* @ORM\Column(name="text",type="text")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $text;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getuser_id()
	{
		return $this->user_id;
	}
	
	public function getimage_id()
	{
		return $this->image_id;
	}
	
	public function getadd_date()
	{
		return $this->add_date;
	}
	
	public function gettext()
	{
		return $this->text;
	}
	
	public function setuser_id($user_id)
	{
		$this->user_id = $user_id;
	}
	
	public function setimage_id($image_id)
	{
		$this->image_id = $image_id;
	}
	
	public function setadd_date($add_date)
	{
		$this->add_date = $add_date;
	}
	
	public function settext($text)
	{
		$this->text = $text;
	}
}