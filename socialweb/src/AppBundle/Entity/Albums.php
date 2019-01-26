<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="albums")
 */
 
class Albums{
	
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
    * @ORM\Column(name="album_name",type="string",length=255)
    * Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
    * 
    */
	private $album_name;
	
	/**
    * @ORM\Column(name="album_access",type="integer")
    * Doctrine\ORM\Mapping\GeneratedValue(strategy="AUTO")
    * 
    */
	private $album_access;
	
	public function getId(){
        return $this->id;
    }
	
	public function getuser_id(){
        return $this->user_id;
    }
	
	public function getalbum_name(){
        return $this->album_name;
    }
	
	public function getalbum_access(){
        return $this->album_access;
    }
	
	public function setuser_id($user_id){
        $this->user_id = $user_id;
    }
	
	public function setalbum_name($album_name){
        $this->album_name = $album_name;
    }
	
	public function setalbum_access($album_access){
        $this->album_access = $album_access;
    }
}
?>