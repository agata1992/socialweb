<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;

class User_profileController extends Controller{
	public function show_profileAction(CookieService $cookie_service,DBService $db_service,Request $request,$user_id,$subpage,$page){

		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		$user_profile_data = $db_service->get_user_profile_data($user_id);
		
		if($user_profile_data == null){
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		}
		elseif($user_data[0] == $user_profile_data->getid())
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
		else{
			$user_profile_data->age=date_diff(new \DateTime(),$user_profile_data->getbirthdate())->y;
			$friendship = $db_service->check_friend($user_profile_data);
			$user_profile_data->friendship = $friendship;
		
			if($subpage == "galeria"){
				$albums_on_page = 4;
				$albums = $db_service->get_user_albums($user_id);
			
				for($i = 0;$i<count($albums);$i++){
					if(($albums[$i]->getalbum_access() == 1))
						unset($albums[$i]);
				
					elseif($albums[$i]->getalbum_access() == 2 && $db_service->check_friend($user_profile_data) != 1)
						unset($albums[$i]);
				}
			
				$count_albums = count($albums);
		
				return $this->render('user_profile.html.twig', array(
				'page_name' => 'Profil','nav_title' => 'Profil użytkownika','user' => $user_data,
				'user_profile' => $user_profile_data,'subpage' =>$subpage,'albums' => $albums,'page' =>$page));
			}
			elseif($subpage == "znajomi"){
				$search_input = $request->request->get('search_friends_input');
				$friends = $db_service->get_friends($user_id,$search_input);
				
				for($i =0;$i<count($friends);$i++){
					$friends[$i]->age=date_diff(new \DateTime(),$friends[$i]->getbirthdate())->y;
					$friends[$i]->friendship = $db_service->check_friend($friends[$i]);
				}
				
				$friends_on_page = 6;
			
				$count_friends = count($friends);
				if(($count_friends/$friends_on_page)<($page-1))
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				
				
				return $this->render('user_profile.html.twig', array(
				'page_name' => 'Profil','nav_title' => 'Profil użytkownika','user' => $user_data,'friends' => $friends,
				'user_profile' => $user_profile_data,'subpage' => $subpage,'page' => $page,'search_input' => $search_input));
			}
			else{
				return $this->render('user_profile.html.twig', array(
				'page_name' => 'Profil','nav_title' => 'Profil użytkownika','user' => $user_data,
				'user_profile' => $user_profile_data,'subpage' => $subpage));
			}
		}	
	}
	
	public function other_user_galeryAction(CookieService $cookie_service,DBService $db_service,$user_id,$album_id,$page){
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		$user_profile_data = $db_service->get_user_profile_data($user_id);
		
		if($user_profile_data == null){
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		}
		else{
			$user_profile_data->age = date_diff(new \DateTime(),$user_profile_data->getbirthdate())->y;
			$friendship = $db_service->check_friend($user_profile_data);
			$user_profile_data->friendship = $friendship;
			
			$album = $db_service->get_user_album_by_id($album_id,$user_profile_data);
			
			if($album == null){
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			}
			else{
				
				$images_on_page = 12;
			
				$images = $db_service->get_images_by_album_id($album_id);
				$count_images = count($images);
			
				if(($count_images/$images_on_page)<($page-1))
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				else
					return $this->render('user_profile.html.twig', array(
					'page_name' => 'Profil','nav_title' => 'Profil użytkownika','user' => $user_data,'user_profile' => $user_profile_data,
					'subpage' => 'album','album' => $album,'images' => $images,'page' => $page));
			}
		}
	}
	
	public function other_user_imagesAction(CookieService $cookie_service,DBService $db_service,$user_id,$album_id,$image_id){
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		$user_profile_data = $db_service->get_user_profile_data($user_id);
		
		if($user_profile_data == null){
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		}
		else{
			$user_profile_data->age=date_diff(new \DateTime(),$user_profile_data->getbirthdate())->y;
			$friendship = $db_service->check_friend($user_profile_data);
			$user_profile_data->friendship = $friendship;
			
			$album = $db_service->get_user_album_by_id($album_id,$user_profile_data);
			
			if($album == null){
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			}
			else{
				
				$image = $db_service->get_image_by_image_id($image_id,$album_id);
			
				if($image == null)
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				else
					return $this->render('user_profile.html.twig', array(
					'page_name' => 'Profil','nav_title' => 'Profil użytkownika','user' => $user_data,'user_profile' => $user_profile_data,
					'subpage' => 'zdjecie','album' => $album,'image' => $image));
			}
		}
	}
}
?>