<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_subcomments")
 */
 
class Group_Subcomments
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
	* @ORM\Column(name="comment_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $comment_id;
	
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
	
	public function getcomment_id()
	{
		return $this->comment_id;
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
	
	public function setcomment_id($comment_id)
	{
		$this->comment_id = $comment_id;
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