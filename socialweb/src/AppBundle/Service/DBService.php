<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use  AppBundle\Entity\Users;
use  AppBundle\Entity\Albums;
use  AppBundle\Entity\Images;


class DBService{
	
    protected $requestStack;
	protected $entityManager;
    protected $user;
	protected $user_data;
	
	public function __construct(RequestStack $requestStack,EntityManager $entityManager){
	    $this->requestStack = $requestStack;
		$this->entityManager = $entityManager;
	}	
	
    public function get_user_cookie(){
	    $request = $this->requestStack->getCurrentRequest();
	    $cookie = $request->cookies;
	    $this->user = $cookie->get("user");
	}	

    public function get_user_data(){
		$this->get_user_cookie();
        $this->user_data = $this->entityManager
        ->getRepository(Users::class)->findOneBy(['email' => $this->user]);
	    
	    $this->user_data_array = array($this->user_data->getid(),$this->user_data->getname(),$this->user_data->getsurname(),
		$this->user_data->getemail(),$this->user_data->getpassword(),$this->user_data->getsalt(),$this->user_data->getcity(),
		$this->user_data->getbirthdate(),$this->user_data->getgender(),$this->user_data->getprofile_img());
		
		return $this->user_data_array;
	}
	
	public function get_user_albums(){
		$this->get_user_data();
	    $albums = $this->entityManager
        ->getRepository(Albums::class)->findBy(['user_id' => $this->user_data_array[0]]);
		return $albums;
	}

    public function get_user_album_by_id($album_id){
		$this->get_user_data();
	    $album = $this->entityManager
        ->getRepository(Albums::class)->findOneBy(['user_id' => $this->user_data_array[0],'id'=>$album_id]);
		
		return $album;
	}
	
	public function get_images_by_album_id($album_id){
	    $this->get_user_data();
	    $images = $this->entityManager
        ->getRepository(Images::class)->findBy(['album_id' => $album_id]);
		return $images;
	
	}
	
	public function get_image_by_image_id($image_id,$album_id){
	    $this->get_user_data();
	    $image = $this->entityManager
        ->getRepository(Images::class)->findOneBy(['id'=>$image_id,'album_id' => $album_id]);
		return $image;
	}
	
	public function save_user_image_info($image_name,$album_id){
		$image = new Images();
		$image->setalbum_id($album_id);
        $image->setimage_name($image_name);
		$image->setdescription('');
		$image->setadd_date(new \DateTime(date("Y-m-d")));
		$this->entityManager->persist($image);
		$this->entityManager->flush();
	}
	
	public function change_album_access($album_id,$album_access){
		$album = $this->get_user_album_by_id($album_id);
		$album->setalbum_access($album_access);
		$this->entityManager->flush();
	}
	
	public function check_album_exists($album_name){
		$this->get_user_data();
		$album = $this->entityManager
        ->getRepository(Albums::class)->findOneBy(['user_id' => $this->user_data_array[0],'album_name'=>$album_name]);
		return $album;
	}
	
	public function setnew_album_name($album_id,$album_name){
		$album = $this->get_user_album_by_id($album_id);
		$album->setalbum_name($album_name);
		$this->entityManager->flush();
	}
	
	public function add_album($album_name){
	    $this->get_user_data();
		$new_album = new Albums();
		$new_album->setuser_id($this->user_data_array[0]);
		$new_album->setalbum_name($album_name);
	    $new_album->setalbum_access(0);
        $this->entityManager->persist($new_album);
		$this->entityManager->flush();	
	}
	
	public function getimages($album_id){
		$images = $this->entityManager
        ->getRepository(Images::class)->findBy(['album_id' => $album_id]);
		
		return $images;
	}
	
	public function remove_image_info($image){
		$this->entityManager->remove($image);
		$this->entityManager->flush();
	}
	
	public function remove_album($album){
		$this->entityManager->remove($album);
	    $this->entityManager->flush();
	}
	
	
	public function check_email($email){
		$email = $this->entityManager
        ->getRepository(Users::class)->findOneBy(['email' => $email]);
		
		return $email;
	}
	
	public function add_user($name,$surname,$email,$password,$salt,$city,$birthdate,$gender){
		$user = new Users();
		$user->setname($name);
        $user->setsurname($surname);
		$user->setemail($email);
		$user->setpassword($password);
		$user->setsalt($salt);
		$user->setcity($city);
		$user->setbirthdate(new \DateTime($birthdate));
		$user->setgender($gender);
		$user->setprofile_img('');
		$this->entityManager->persist($user);
		$this->entityManager->flush();	
		
		
	}
	
	
}








?>