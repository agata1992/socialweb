<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use  AppBundle\Entity\Users;
use  AppBundle\Entity\Albums;
use  AppBundle\Entity\Images;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;
use AppBundle\Service\FileService;

class Main_PageController extends Controller{

	public function indexAction(CookieService $cookie_service,DBService $db_service,Request $request,$subpage,$page){
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();

		if($subpage == "galeria"){
			
			$user_id = $user_data[0];

			$albums_on_page = 4;
			$albums = $db_service->get_user_albums();
			$count_albums = count($albums);
			
			if(($count_albums/$albums_on_page)<($page-1))
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else
				return $this->render('main_page.html.twig', array(
				'page_name' => 'Strona Główna','nav_title' => 'Strona Główna','user' => $user_data,
				'subpage' => $subpage,'albums' => $albums,'page' =>$page));
		}
		elseif($subpage == "znajomi"){
			
			$search_input = $request->request->get('search_friends_input');
			$friends = $db_service->get_friends('',$search_input);
			
			for($i =0;$i<count($friends);$i++){
				$friends[$i]->age=date_diff(new \DateTime(),$friends[$i]->getbirthdate())->y;
			}
				
			$friends_on_page = 6;
			
			$count_friends = count($friends);
			
			if(($count_friends/$friends_on_page)<($page-1))
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else	
				return $this->render('main_page.html.twig', array(
				'page_name' => 'Strona Główna','nav_title' => 'Strona Główna','user' => $user_data,'friends' => $friends,
				'subpage' => $subpage,'page' =>$page,'search_input' => $search_input));
		}
		else{
			return $this->render('main_page.html.twig', array(
			'page_name' => 'Strona Główna','nav_title' => 'Strona Główna','user' => $user_data,
			'subpage' => $subpage));
		}
	}

	public function galeryAction(CookieService $cookie_service,DBService $db_service,$album_id,$page){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$album = $db_service->get_user_album_by_id($album_id);
		
		if($album == null)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		
		else{
		
			$images_on_page =12;
		
			$images = $db_service->get_images_by_album_id($album_id);
			$count_images = count($images);
			
			if(($count_images/$images_on_page)<($page-1))
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else
				return $this->render('main_page.html.twig', array(
				'page_name' => 'Strona Główna','nav_title' => 'Strona Główna','user' => $user_data,
				'subpage' => 'album','album' => $album,'images' => $images,'page' => $page));
		}
	}

	public function imagesAction(CookieService $cookie_service,DBService $db_service,$album_id,$image_id,$page){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$album = $db_service->get_user_album_by_id($album_id);

		if($album == null)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		else{
		
			$image = $db_service->get_image_by_image_id($image_id,$album_id);
			
			if($image == null)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else{
			
				$image_comments = $db_service->getimage_comments($image_id);
				$image_comments_array = array();
				
				for($i = 0;$i<count($image_comments);$i++)
					$image_comments_array[$i] = $image_comments[$i]['id'];
				
				$image_subcomments = $db_service->getimage_subcomments($image_comments_array);
				
				return $this->render('main_page.html.twig', array(
				'page_name' => 'Strona Główna','nav_title' => 'Strona Główna','user' => $user_data,
				'subpage' => 'zdjecie','album' => $album,'image' => $image,'image_comments' => $image_comments,
				'image_subcomments' => $image_subcomments,'page' => $page));
			}
		}
	}

	public function uploadAction(CookieService $cookie_service,DBService $db_service,FileService $file_service,Request $request,$album_id){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$album = $db_service->get_user_album_by_id($album_id);

		if($album == null)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' =>' Strona Główna',
			'user' => $user_data));
		
		$results = array();

		if($request->isXmlHttpRequest() == "true"){
		
			if(isset($_FILES["add-image"])){
			
				$results = $file_service->save_user_image($_FILES["add-image"]);

				if($results[0] == ''){
				
					try {
					
						$db_service->save_user_image_info($results[1],$album_id);
					}
					catch(\Doctrine\DBAL\DBALException $e){
					
						$db_service->remove_user_image($results[1]);
						$results[0] = "Wystapil blad";
					}

				}
			}
			else
				$results[0] = "Wystapil blad";

			return new JsonResponse($results[0]);
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}

	public function album_accessAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();

		$album = $db_service->get_user_album_by_id($album_id);

		if($album == null)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		
		else
			$album_access = $request->request->get('album_access');
			$db_service->change_album_access($album_id,$album_access);
			return new JsonResponse('');
	}

	public function change_album_nameAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $this->getDoctrine()
		->getRepository(Users::class)->findOneBy(['email' => $user]);

		$user_data = $db_service->get_user_data();

		$album = $db_service->get_user_album_by_id($album_id);

		if($album == null)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
			'user' => $user_data));
		else{

			$results = '';
			$album_name = $request->request->get('name');

			if($album_name == '')
				$results = "Wpisano pusta nazwe";
			else{
			
				$album2 = $db_service->check_album_exists($album_name);

				if($album2 == null){
				
					$db_service->setnew_album_name($album_id,$album_name);
					$results = "";
				}
				else
					$results = "Nazwa juz istnieje";
			}
			
			return new JsonResponse($results);
		}
	}

	public function add_albumAction(CookieService $cookie_service,DBService $db_service,Request $request){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $this->getDoctrine()
		->getRepository(Users::class)->findOneBy(['email' => $user]);

		$user_data = $db_service->get_user_data();
		$album_name = $request->request->get('name');
		$results = '';

		if($album_name == '')
			$results = "Wpisano pusta nazwe";
		
		else{
		
			$album = $db_service->check_album_exists($album_name);

			if($album == null){
			
				try{
				
					$db_service->add_album($album_name);
					$results = "";
				}
				catch(\Doctrine\DBAL\DBALException $e){
				
					$results = "Wystapil blad";
				}
			}
			else
				$results = "Nazwa juz istnieje";
		}

		return new JsonResponse($results);
	}

	public function delete_albumAction(CookieService $cookie_service,DBService $db_service,FileService $file_service,Request $request,$album_id){
		
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $this->getDoctrine()
			->getRepository(Users::class)->findOneBy(['email' => $user]);
			
			$album = $db_service->get_user_album_by_id($album_id);

			if($album == null)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else{

				try{
				
					$images = $db_service->getimages($album_id);

					for($i = 0;$i<count($images);$i++){
					
						$image_name = $images[$i]->getimage_name();
						$file_service->remove_user_image($image_name);
						$db_service->remove_image_info($images[$i]);
					}

					$db_service->remove_album($album);
				}
				catch(\Doctrine\DBAL\DBALException $e){;}

				return new JsonResponse('');
			}
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}

	public function edit_img_descriptionAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id,$image_id){
		
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $this->getDoctrine()
			->getRepository(Users::class)->findOneBy(['email' => $user]);

			$user_data = $db_service->get_user_data();
			$description = $request->request->get('description');
			$album = $db_service->get_user_album_by_id($album_id);

			if($album == null)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			
			else{
			
				$image = $db_service->get_image_by_image_id($image_id,$album_id);
			
				if($image == null)
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				else{
					
					$results = '';
					
					if(strlen($description) > 255)
						$results = "Opis nie może być dłuższy niż 255 znaków";
					else
						$db_service->set_image_description($description,$image);
				}
				
				return new JsonResponse($results);
			}
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}
	
	public function delete_imgAction(CookieService $cookie_service,DBService $db_service,FileService $file_service,Request $request,$album_id,$image_id){
		
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $this->getDoctrine()
			->getRepository(Users::class)->findOneBy(['email' => $user]);

			$user_data = $db_service->get_user_data();
			$album = $db_service->get_user_album_by_id($album_id);

			if($album == null)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			
			else{
			
				$image = $db_service->get_image_by_image_id($image_id,$album_id);
			
				if($image == null)
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				else
					
					$file_service->remove_user_image($image->getimage_name());
					$db_service->remove_image_info($image);
			}
		
			return new JsonResponse('');
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}
	
	public function set_as_profile_imgAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id,$image_id){
		
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $this->getDoctrine()
			->getRepository(Users::class)->findOneBy(['email' => $user]);

			$user_data = $db_service->get_user_data();
			$album = $db_service->get_user_album_by_id($album_id);

			if($album == null)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
				'user' => $user_data));
			else{
			
				$image = $db_service->get_image_by_image_id($image_id,$album_id);
			
				if($image == null)
					return $this->render('page_no_found.html.twig',array(
					'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Główna',
					'user' => $user_data));
				else
					$db_service->set_as_profile_image($image);
			}
		
			return new JsonResponse('');
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}
}
?>