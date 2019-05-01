<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="invitations")
 */
 
class Invitations
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	*/
	private $id;
	
	/**
	* @ORM\Column(name="user1_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $user1_id;
	
	/**
	* @ORM\Column(name="user2_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $user2_id;
	
	/**
	* @ORM\Column(name="add_date",type="datetime")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $add_date;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getuser1_id()
	{
		return $this->user1_id;
	}
	
	public function getuser2_id()
	{
		return $this->user2_id;
	}
	
	public function getadd_date()
	{
		return $this->add_date;
	}
	
	public function setuser1_id($user1_id)
	{
		$this->user1_id = $user1_id;
	}
	
	public function setuser2_id($user2_id)
	{
		$this->user2_id = $user2_id;
	}
	
	public function setadd_date($add_date)
	{
		$this->add_date = $add_date;
	}
}