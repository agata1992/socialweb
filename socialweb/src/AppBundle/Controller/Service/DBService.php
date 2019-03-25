<?php

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Users;
use AppBundle\Entity\Albums;
use AppBundle\Entity\Images;
use AppBundle\Entity\Friends;
use AppBundle\Entity\Invitations;
use AppBundle\Entity\Image_Comments;
use AppBundle\Entity\Image_Subcomments;
use AppBundle\Entity\Groups;
use AppBundle\Entity\Group_Members;

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
	
	public function get_user_albums($user_id=''){
		
		if($user_id ==''){
			$this->get_user_data();
			$albums = $this->entityManager
			->getRepository(Albums::class)->findBy(['user_id' => $this->user_data_array[0]]);
		}
		else{
			$albums = $this->entityManager
			->getRepository(Albums::class)->findBy(['user_id' => $user_id]);
		}
		return $albums;
	}

	public function get_user_album_by_id($album_id,$user_profile_data =''){
		
		if($user_profile_data == ''){
			$this->get_user_data();
			$album = $this->entityManager
			->getRepository(Albums::class)->findOneBy(['user_id' => $this->user_data_array[0],'id'=>$album_id]);
		}
		else{
			$album = $this->entityManager
			->getRepository(Albums::class)->findOneBy(['user_id' => $user_profile_data->getid(),'id'=>$album_id]);
			
			if(($album->getalbum_access() == 1) || ($album->getalbum_access() == 2 && $this->check_friend($user_profile_data) != 1))
				$album = null;
		}
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
		$this->entityManager->persist($album);
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
	
	public function set_image_description($description,$image){
		
		$image->setdescription($description);
		$this->entityManager->persist($image);
		$this->entityManager->flush();
	}
	
	public function set_as_profile_image($image){
		
		$this->get_user_data();
		$user = $this->entityManager
		->getRepository(Users::class)->findOneBy(['id' => $this->user_data_array[0]]);
		
		
		$user->setprofile_img($image->getimage_name());
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
	
	public function search_users($name,$city,$gender){
		
		$this->get_user_data();
		
		$search_users = $this->entityManager
		->getRepository(Users::class)->createQueryBuilder('u')
		->where('CONCAT(u.name,  \' \',u.surname) LIKE :name and u.id <> :my_id and u.city LIKE :city')->setParameter(":name", '%'.$name.'%')
		->setParameter(":city", '%'.$city.'%')->setParameter(":my_id",$this->user_data_array[0]);
		
		if($gender != '')
			$search_users = $search_users->andwhere('u.gender = :gender')->setParameter(":gender", $gender);
		
		$search_users = $search_users->getQuery()->getResult();
		
		return $search_users;
	}
	
	public function check_friend($searched_user){
		
		$this->get_user_data();
		
		$results = 0;
		$friends = $this->entityManager
		->getRepository(Friends::class)->findOneBy(['user1_id' => $this->user_data_array[0],'user2_id' => $searched_user->getid()]);
		
		$friends2 = $this->entityManager
		->getRepository(Friends::class)->findOneBy(['user1_id' => $searched_user->getid(),'user2_id' => $this->user_data_array[0]]);
		
		$invitations = $this->entityManager
		->getRepository(Invitations::class)->findOneBy(['user1_id' => $this->user_data_array[0],'user2_id' => $searched_user->getid()]);
		
		$invitations2 = $this->entityManager
		->getRepository(Invitations::class)->findOneBy(['user1_id' => $searched_user->getid(),'user2_id' => $this->user_data_array[0]]);
		
		if($friends != null || $friends2 !=null )
			$results = 1;
		
		if($invitations != null || $invitations2 != null)
			$results = 2;
		
		return $results;
	}
	
	public function invitations($friend_id){
		
		$this->get_user_data();
		
		$user = $this->entityManager
		->getRepository(Users::class)->findOneBy(['id' => $friend_id]);
		
		if(!$user == null){
		
			$friends1 = $this->entityManager
			->getRepository(Friends::class)->findOneBy(['user1_id' => $this->user_data_array[0],'user2_id' =>$friend_id]);
			
			$friends2 = $this->entityManager
			->getRepository(Friends::class)->findOneBy(['user1_id' => $friend_id,'user2_id' => $this->user_data_array[0]]);
			
			$invitations1 = $this->entityManager
			->getRepository(Invitations::class)->findOneBy(['user1_id' => $this->user_data_array[0],'user2_id' =>$friend_id]);
			
			$invitations2 = $this->entityManager
			->getRepository(Invitations::class)->findOneBy(['user1_id' => $friend_id,'user2_id' => $this->user_data_array[0]]);
			
			if($friends1 == null && $friends2 == null && $invitations1 == null && $invitations2 == null){
				$invitations_ = new Invitations();
				$invitations_->setuser1_id($this->user_data_array[0]);
				$invitations_->setuser2_id($friend_id);
				$invitations_->setadd_date(new \DateTime(date("Y-m-d H:i")));
				
				$this->entityManager->persist($invitations_);
				$this->entityManager->flush();
			}
		}
	}
	
	public function delete_friend($friend_id){
		
		$this->get_user_data();
		
		$friend1 = $this->entityManager
		->getRepository(Friends::class)->findOneBy(['user1_id' => $this->user_data_array[0],'user2_id' => $friend_id]);
			
		$friend2 = $this->entityManager
		->getRepository(Friends::class)->findOneBy(['user1_id' => $friend_id,'user2_id' => $this->user_data_array[0]]);
		
		if(!$friend1 == null ){
			$this->entityManager->remove($friend1);
		}
		
		if(!$friend2 == null )
			$this->entityManager->remove($friend2);
		
		$this->entityManager->flush();
		
	}
	
	public function get_user_profile_data($user_id){
		
		$user_profile_data = $this->entityManager
		->getRepository(Users::class)->findOneBy(['id' => $user_id]);
		
		if($user_profile_data !=null){
			$user_profile_data_array = array($user_profile_data->getid(),$user_profile_data->getname(),$user_profile_data->getsurname(),
			$user_profile_data->getemail(),$user_profile_data->getpassword(),$user_profile_data->getsalt(),$user_profile_data->getcity(),
			$user_profile_data->getbirthdate(),$user_profile_data->getgender(),$user_profile_data->getprofile_img());
		
			return $user_profile_data;
		}
		else
			return null;
	}
	
	public function get_friends($user_id,$search_input){
		
		if($user_id == ''){
			$this->get_user_data();
			$user_id = $this->user_data_array[0];
		}
		
		$friend_users = $this->entityManager
		->getRepository(Friends::class)->createQueryBuilder('f')
		->where('f.user1_id = :user or  f.user2_id = :user')->setParameter(":user",$user_id)
		->getQuery()->getResult();
	
		$friends_id_array =array();
		
		for($i = 0;$i<count($friend_users);$i++){
			if($friend_users[$i]->getuser1_id() == $user_id)
				$friend_id = $friend_users[$i]->getuser2_id();
			else
				$friend_id = $friend_users[$i]->getuser1_id();
			
			$friends_id_array[$i] = $friend_id;
		}
		
		$friends = $this->entityManager
			->getRepository(Users::class)->createQueryBuilder('u')->orderBy('CONCAT(u.name,  \' \',u.surname)', 'ASC')
			->where('u.id in  (:friends_id_array)')->setParameter(":friends_id_array",$friends_id_array);
			
		if($search_input != '')
			$friends = $friends->andwhere('CONCAT(u.name,  \' \',u.surname) LIKE :name')
			->setParameter(":name",'%'.$search_input.'%');
		
		$friends = $friends->getQuery()->getResult();
		
		return $friends;
	}
	
	public function getimage_comments($image_id){
		
		$comments = $this->entityManager
		->createQueryBuilder()->select('ii.id,ii.user_id,ii.add_date,ii.text','u.name,u.surname,u.profile_img')
		->from('AppBundle:Image_Comments','ii')
		->leftjoin('AppBundle:Users','u','WITH','u.id = ii.user_id')
		->orderBy('ii.add_date', 'ASC')
		->where('ii.image_id = :image_id')->setParameter(":image_id",$image_id)->getQuery()->getResult();
		
		return $comments;
	}
	
	public function getimage_subcomments($image_comment_id_array){
		
		$subcomments = $this->entityManager
		->createQueryBuilder()->select('ii.id,ii.user_id,ii.image_comment_id,ii.add_date,ii.text','u.name,u.surname,u.profile_img')
		->from('AppBundle:Image_Subcomments','ii')
		->join('AppBundle:Users','u','WITH','u.id =ii.user_id')
		->orderBy('ii.add_date', 'ASC')
		->where('ii.image_comment_id in(:image_comment_id_array)')->setParameter(":image_comment_id_array",$image_comment_id_array)
		->getQuery()->getResult();
		
		return $subcomments;
	}
	
	public function add_image_commment($type,$image_comment,$image_id,$comment_id){
		
		$this->get_user_data();
		
		if($type == 1){
		
			$comment = new Image_Comments();
			$comment->setuser_id($this->user_data_array[0]);
			$comment->setimage_id($image_id);
			$comment->setadd_date(new \DateTime(date("Y-m-d H:i")));
			$comment->settext($image_comment);
		
			$this->entityManager->persist($comment);
			$this->entityManager->flush();
		}
		
		if($type == 0){
		
			$subcomment = new Image_Subcomments();
			$subcomment->setuser_id($this->user_data_array[0]);
			$subcomment->setimage_comment_id($comment_id);
			$subcomment->setadd_date(new \DateTime(date("Y-m-d H:i")));
			$subcomment->settext($image_comment);
		
			$this->entityManager->persist($subcomment);
			$this->entityManager->flush();
		}
	}
	
	public function change_personal_data($name,$surname,$city,$birthdate,$gender){
		
		$this->get_user_data();
		$user = $this->entityManager
		->getRepository(Users::class)->findOneBy(['id' => $this->user_data_array[0]]);
		
		$user->setname($name);
		$user->setsurname($surname);
		$user->setcity($city);
		$user->setbirthdate(new \DateTime($birthdate));
		$user->setgender($gender);
		
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
	
	public function change_password($new_password,$salt){
		
		$this->get_user_data();
		$user = $this->entityManager
		->getRepository(Users::class)->findOneBy(['id' => $this->user_data_array[0]]);
		
		$user->setpassword($new_password);
		$user->setsalt($salt);
		
		$this->entityManager->persist($user);
		$this->entityManager->flush();
	}
	
	public function get_groups($category,$search_input){
		
		if($category == ''){
			
			$groups = $this->entityManager
			->getRepository(Groups::class)->createQueryBuilder('g')
			->where('g.title LIKE :title and g.type = 0')->setParameter(":title", '%'.$search_input.'%');
			
			$groups = $groups->getQuery()->getResult();
			
		}
		else{
		
			$groups = $this->entityManager
			->getRepository(Groups::class)->findBy(['type' => 0,'category' => $category]);
			
			$groups = $this->entityManager
			->getRepository(Groups::class)->createQueryBuilder('g')
			->where('g.title LIKE :title and g.type = 0 and g.category = :category')->setParameter(":title", '%'.$search_input.'%')
			->setParameter(":category", $category);
			
			$groups = $groups->getQuery()->getResult();
		}
		
		return $groups;
	}
	
	public function create_group($title,$description,$category,$type){
		
		$this->get_user_data();
		
		$group = new Groups();
		$group->setowner_id($this->user_data_array[0]);
		$group->settitle($title);
		$group->setdescription($description);
		$group->setcategory($category);
		$group->settype($type);
		$group->setadd_date(new \DateTime(date("Y-m-d")));
		$group->setimage('');
		
		$this->entityManager->persist($group);
		$this->entityManager->flush();
		
		$last_id = $group->getId();
		
		$group_member = new Group_Members();
		$group_member->setuser_id($this->user_data_array[0]);
		$group_member->setgroup_id($last_id);
		$group_member->setadd_date(new \DateTime(date("Y-m-d")));
		
		$this->entityManager->persist($group_member);
		$this->entityManager->flush();
		
		return $last_id;
	}
	
	public function get_group($id){
	
		$this->get_user_data();
		
		$group = $this->entityManager
		->getRepository(Groups::class)->findOneBy(['id' => $id]);
		
		if($group != NULL){
			
			if($group->gettype() == 1){
				if($group->getowner_id() != $this->user_data_array[0]){
				
					$group_member = $this->entityManager
					->getRepository(Group_Members::class)->findOneBy(['user_id' => $this->user_data_array[0],'group_id' => $id]);
					
					if($group_member == NULL)
						$group = NULL;
				}
			}
		}
			
		return $group;
	}
	
	public function get_group_owner($id){
		
		$group = $this->entityManager
		->getRepository(Groups::class)->findOneBy(['id' => $id]);
		
		$owner_user = $this->get_user_profile_data($group->getowner_id());
		
		return $owner_user;
	}
	
	public function get_group_users($id){
		
		$group_users = $this->entityManager
		->createQueryBuilder()->select('g.user_id ,u.name,u.surname,u.city,u.birthdate,u.profile_img')->from('AppBundle:Group_Members','g')
		->join('AppBundle:Users','u','WITH','u.id =g.user_id')->orderBy('CONCAT(u.name,  \' \',u.surname)', 'ASC')
		->where('g.group_id = :id')->setParameter(":id",$id)->getQuery()->getResult();
		
		return $group_users;
	}
	
	public function join_group($id){
		
		$this->get_user_data();
		
		$group_member = new Group_Members();
		$group_member->setuser_id($this->user_data_array[0]);
		$group_member->setgroup_id($id);
		$group_member->setadd_date(new \DateTime(date("Y-m-d")));
		
		$this->entityManager->persist($group_member);
		$this->entityManager->flush();
	}
	
	public function unjoin_group($group_id){
		
		$this->get_user_data();
		
		$group_member = $this->entityManager
		->getRepository(Group_Members::class)->findOneBy(['group_id' => $group_id,'user_id' => $this->user_data_array[0]]);
		
		$this->entityManager->remove($group_member);
		$this->entityManager->flush();
	}
	
}
?>