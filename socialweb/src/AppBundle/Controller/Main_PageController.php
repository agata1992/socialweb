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

	public function indexAction(CookieService $cookie_service,DBService $db_service,$subpage){
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];

		if($subpage == "galeria"){
			$user_id =  $user_data[0];

		    $albums = $db_service->get_user_albums();

		    return $this->render('main_page.html.twig', array(
            'page_name' => 'Strona Glówna','nav_title' => 'Strona Glówna','user' => $user,
			'name' => $name,'surname' => $surname,'subpage' => $subpage,'albums' => $albums));
		}
		else{
		    return $this->render('main_page.html.twig', array(
            'page_name' => 'Strona Glówna','nav_title' => 'Strona Glówna','user' => $user,
			'name' => $name,'surname' => $surname,'subpage' => $subpage));
		}
	}

	public function galeryAction(CookieService $cookie_service,DBService $db_service,$album_id){
	    $user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

        $user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

		$album = $db_service->get_user_album_by_id($album_id);

	    if($album == null){
			return $this->render('page_no_found.html.twig',array(
            'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Glówna',
			'user' => $user,'name' => $name,'surname' => $surname));
		}
	    else{
		    $images = $db_service->get_images_by_album_id($album_id);
		    return $this->render('main_page.html.twig', array(
            'page_name' => 'Strona Glówna','nav_title' => 'Strona Glówna','user' => $user,
			'name' => $name,'surname' => $surname,'subpage' => 'album','album' => $album,'images' => $images));
		}
	}

	public function imagesAction(CookieService $cookie_service,DBService $db_service,$album_id,$image_id){
	    $user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

	    $album = $db_service->get_user_album_by_id($album_id);

	    if($album == null){
			return $this->render('page_no_found.html.twig',array(
            'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Glówna',
			'user' => $user,'name' => $name,'surname' => $surname));
		}
	    else{
		    $image = $db_service->get_image_by_image_id($image_id,$album_id);

		    return $this->render('main_page.html.twig', array(
            'page_name' => 'Strona Glówna','nav_title' => 'Strona Glówna','user' => $user,
			'name' => $name,'surname' => $surname,'subpage' => 'zdjecie','album' => $album,'image' => $image));
		}
	}


	public function uploadAction(CookieService $cookie_service,DBService $db_service,FileService $file_service,Request $request,$album_id){
	    $user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

		$album = $db_service->get_user_album_by_id($album_id);

	    if($album == null){
			return $this->render('page_no_found.html.twig',array(
            'page_name' => 'Nie znaleziono strony','nav_title'=>'Strona Glówna',
			'user' => $user,'name' => $name,'surname' => $surname));
		}

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
	    else{
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');

	    }
	}

	public function album_accessAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id){
	    $user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

		$album = $db_service->get_user_album_by_id($album_id);

	    if($album == null){
			return $this->render('page_no_found.html.twig',array(
            'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Glówna',
			'user' => $user,'name' => $name,'surname' => $surname));
		}
		else{
		    $album_access = $request->request->get('album_access');
		    $db_service->change_album_access($album_id,$album_access);
		    return new JsonResponse('');
		}
	}

	public function change_album_nameAction(CookieService $cookie_service,DBService $db_service,Request $request,$album_id){
	    $user = $cookie_service->check_exist_user_cookie();

		if($user == '')
		    return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $this->getDoctrine()
        ->getRepository(Users::class)->findOneBy(['email' => $user]);

		$user_data = $db_service->get_user_data();
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

		$album = $db_service->get_user_album_by_id($album_id);

	    if($album == null){
			return $this->render('page_no_found.html.twig',array(
            'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Glówna',
			'user' => $user,'name' => $name,'surname' => $surname));
		}
		else{

		    $results = '';
		    $album_name = $request->request->get('name');

			if($album_name == ''){
				$results = "Wpisano pusta nazwe";
			}
			else{
		        $album2 = $db_service->check_album_exists($album_name);

		        if($album2 == null){
				    $db_service->setnew_album_name($album_id,$album_name);
				    $results = "";
			    }
			    else{
				    $results = "Nazwa juz istnieje";
				}
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
		$name = $user_data[1];
		$surname = $user_data[2];
		$user_id = $user_data[0];

		$album_name = $request->request->get('name');
		$results = '';

	    if($album_name == ''){
		    $results = "Wpisano pusta nazwe";
		}
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
			else{
				$results = "Nazwa juz istnieje";
			}
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

		    $user_data = $db_service->get_user_data();
		    $name = $user_data[1];
		    $surname = $user_data[2];
		    $user_id = $user_data[0];;

		    $album = $db_service->get_user_album_by_id($album_id);

	        if($album == null){
			    return $this->render('page_no_found.html.twig',array(
                'page_name' => 'Nie znaleziono strony','nav_title' => 'Strona Glówna',
			    'user' => $user,'name' => $name,'surname' => $surname));
		    }
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










}


?>