<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;

class AccountController extends Controller{

	public function indexAction(CookieService $cookie_service,DBService $db_service,$subpage){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		return $this->render('account.html.twig', array(
			'page_name' => 'Moje konto','nav_title' => 'Moje konto','user' => $user_data, 'subpage' => $subpage));

	}
	
	public function change_personal_dataAction(CookieService $cookie_service,DBService $db_service,Request $request,$subpage){
	
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
		
			$name = $request->request->get('name');
			$surname = $request->request->get('surname');
			$city = $request->request->get('city');
			$birthdate = $request->request->get('birthdate');
			$gender = $request->request->get('gender');
			
			$results = array();
			
			if($name =='')
				$results[0] = 'Wpisz imię';
			else
				$results[0] = '';
			
			if($surname =='')
				$results[1] = 'Wpisz nazwisko';
			else
				$results[1] = '';
			
			if($birthdate =='')
				$results[2] = 'Wpisz datę';
			elseif(date("Y-m-d")<$birthdate)
				$results[2] = 'Niepoprawna data';
			else
				$results[2] = '';
			
			if($results[0] == '' && $results[1] == '' && $results[2] == '' )
				$db_service->change_personal_data($name,$surname,$city,$birthdate,$gender);
				
			return new JsonResponse($results);
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}
}
?>

