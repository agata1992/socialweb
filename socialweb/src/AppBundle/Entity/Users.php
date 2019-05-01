<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
 
class Users
{
	
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	*/
	private $id;
	
	/**
	* @ORM\Column(name="name",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $name;
	
	/**
	* @ORM\Column(name="surname",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $surname;
	
	/**
	* @ORM\Column(name="email",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $email;
	
	/**
	* @ORM\Column(name="password",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $password;
	
	/**
	* @ORM\Column(name="salt",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	
	private $salt;
	
	/**
	* @ORM\Column(name="city",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $city;
	
	/**
	* @ORM\Column(name="birthdate",type="date")
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $birthdate;
	
	/**
	* @ORM\Column(name="gender",type="string",length=100)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $gender;
	
	/**
	* @ORM\Column(name="profile_img",type="string",length=255)
	* Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
	* 
	*/
	private $profile_img;
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getname()
	{
		return $this->name;
	}
	
	public function getsurname()
	{
		return $this->surname;
	}
	
	public function getemail()
	{
		return $this->email;
	}
	
	public function getpassword()
	{
		return $this->password;
	}
	
	public function getsalt()
	{
		return $this->salt;
	}
	
	public function getcity()
	{
		return $this->city;
	}
	
	public function getbirthdate()
	{
		return $this->birthdate;
	}
	
	public function getgender()
	{
		return $this->gender;
	}
	
	public function getprofile_img()
	{
		return $this->profile_img;
	}
	
	public function setname($name)
	{
		$this->name = $name;
	}
	
	public function setsurname($surname)
	{
		$this->surname = $surname;
	}
	
	public function setemail($email)
	{
		$this->email = $email;
	}
	
	public function setpassword($password)
	{
		$this->password = $password;
	}
	
	public function setsalt($salt)
	{
		$this->salt = $salt;
	}
	
	public function setcity($city)
	{
		$this->city = $city;
	}
	
	public function setbirthdate($birthdate)
	{
		$this->birthdate = $birthdate;
	}
	
	public function setgender($gender)
	{
		$this->gender = $gender;
	}
	
	public function setprofile_img($profile_img)
	{
		$this->profile_img = $profile_img;
	}
}