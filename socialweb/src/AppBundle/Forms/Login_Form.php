<?php
namespace AppBundle\Forms;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


class Login_Form
{
	
	/**
	* @ORM\Column(name="email",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz email")
	* 
	*/
	
	protected $email;
	
	/**
	* @ORM\Column(name="password",type="string",length=255)
	* @Assert\NotBlank(message="Wpisz hasło")
	*
	* 
	*/
	
	protected $password;
	
	public function getEmail()
    {
        return $this->email;
    }
	
	public function getPassword()
    {
        return $this->password;
    }
	
	public function setEmail($email)
    {
        $this->email = $email;
    }
	
	public function setPassword($password)
    {
        $this->password = $password;
    }
}