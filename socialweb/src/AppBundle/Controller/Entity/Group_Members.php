<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_members")
 */
 
class Group_Members{
	
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
	* @ORM\Column(name="group_id",type="integer")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $group_id;
	
	/**
	* @ORM\Column(name="add_date",type="date")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $add_date;
	
	public function getId(){
		return $this->id;
	}
	
	public function getuser_id(){
		return $this->user_id;
	}
	
	public function getgroup_id(){
		return $this->group_id;
	}
	
	public function getadd_date(){
		return $this->add_date;
	}
	
	public function setuser_id($user_id){
		$this->user_id = $user_id;
	}	
	
	public function setgroup_id($group_id){
		$this->group_id = $group_id;
	}	
	
	public function setadd_date($add_date){
		$this->add_date = $add_date;
	}
}
?>