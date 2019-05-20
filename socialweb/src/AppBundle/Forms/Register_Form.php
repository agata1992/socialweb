<?php
namespace AppBundle\Forms;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


class Register_Form
{
	
	/**
	* @ORM\Column(name="name",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz imię")
	* 
	*/
	
    protected $name;
	
	/**
	* @ORM\Column(name="surname",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz nazwisko")
	* 
	*/
	
	protected $surname;
    
	/**
	* @ORM\Column(name="email",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz email")
	* @Assert\Email(message="Nieprawidłowy email")
	* 
	*/
	
	protected $email;
	
	/**
	* @ORM\Column(name="email2",type="string",length=255)
	* @Assert\NotBlank(message="Powtórz email")
	* @Assert\Email(message="Nieprawidłowy email")
	* 
	*/
	
	protected $email2;
	
	/**
	* @ORM\Column(name="password",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz hasło")
	*
	* 
	*/
	
	protected $password;
	
	/**
	* @ORM\Column(name="city",type="string",length=255)
	* 
	*
	* 
	*/
	
	protected $city;
	
	/**
	* @ORM\Column(name="birthdate",type="date",length=255)
	* @Assert\NotBlank(message="Wpisz datę")
	*
	* 
	*/
	
	protected $birthdate;
	
	/**
	* @ORM\Column(name="gender",type="string",length=255)
	* @Assert\NotBlank(message="Wybierz płeć")
	*
	* 
	*/
	
	protected $gender;
	
    public function getName()
    {
        return $this->name;
    }
	
	public function getSurname()
    {
        return $this->surname;
    }

	public function getEmail()
    {
        return $this->email;
    }
	
	public function getEmail2()
    {
        return $this->email2;
    }
	
	public function getPassword()
    {
        return $this->password;
    }
	
	public function getCity()
    {
        return $this->city;
    }
	
	public function getBirthdate()
    {
        return $this->birthdate;
    }
	
	public function getGender()
    {
        return $this->gender;
    }
	
    public function setName($name)
    {
        $this->name = $name;
    }
	
	public function setSurname($surname)
    {
        $this->surname = $surname;
    }
	
	public function setEmail($email)
    {
        $this->email = $email;
    }
	
	public function setEmail2($email2)
    {
        $this->email2 = $email2;
    }
	
	public function setPassword($password)
    {
        $this->password = $password;
    }
	
    public function setCity($city)
    {
        $this->city = $city;
    }
	
	public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
	
	public function setGender($gender)
    {
        $this->gender = $gender;
    }
}