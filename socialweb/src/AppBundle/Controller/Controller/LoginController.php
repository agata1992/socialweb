<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;
use AppBundle\Service\AdditionalService;

use  AppBundle\Entity\Users;


class LoginController extends Controller{
	
	public function indexAction(CookieService $cookie_service){
		
		$user = $cookie_service->check_exist_user_cookie();
		
		if($user != '')
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
			
		return $this->render('login.html.twig', array(
		'page_name' => 'Logowanie','user' => $user,'nav_title' => 'Zaloguj się'));
	}
	
	public function registerAction(DBService $db_service,AdditionalService $additional_service,Request $request){
		
		$name = $request->request->get('name');
		$surname = $request->request->get('surname');
		$email = $request->request->get('email');
		$email2 = $request->request->get('email2');
		$password = $request->request->get('password');
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
	
		$check_email = $db_service->check_email($email);
	
		if($email =='')
			$results[2] = 'Wpisz email';
		elseif(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$results[2] = 'Wpisz poprawny email';
		elseif(!$check_email == null)
			$results[2] = 'Adres jest już w użyciu';
		else
			$results[2] = '';
	
		if($results[2] == '')
			if($email2 =='')
				$results[3] = 'Powtórz email';
			elseif($email != $email2)
				$results[3] = 'Adresy nie są identyczne';
			else
				$results[3] = '';
		else
			$results[3] = '';
	
		if($password =='')
			$results[4] = 'Wpisz hasło';
		elseif(!$additional_service->_s_has_upper_letters($password) || !$additional_service->_s_has_lower_letters($password)
		|| !$additional_service->_s_has_numbers($password) || !$additional_service->_s_has_special_chars($password))
			$results[4] = 'Hasło musi zawierać dużą litere,małą,liczbę oraz znak specjalny';
		else
			$results[4] ='';
	
		if($birthdate =='')
			$results[5] = 'Wpisz datę';
		elseif(date("Y-m-d")<$birthdate)
			$results[5] = 'Niepoprawna data';
	    else
		    $results[5] = '';
	
		if(!($gender == 'Kobieta' || $gender  == 'Mężczyzna'))
			$results[6] = 'Wybierz płeć';
		else
			$results[6] = '';
	
		$is_error = 0;
	
		for($i = 0;$i<count($results);$i++){
			
			if( !$results[$i] =='' ){
				
				$is_error = 1;
				break;
			}
		}
	
		if($is_error == 0){
			
			$salt = uniqid();
			$password = $password.$salt;
			$password = md5($password);
			$db_service->add_user($name,$surname,$email,$password,$salt,$city,$birthdate,$gender);
		}
	
		return new JsonResponse($results);
	}
	
	public function loginAction(CookieService $cookie_service,DBService $db_service,Request $request){
		
		$email = $request->request->get('email');
		$password = $request->request->get('password');
	
		$results = '';
	
		$check_email = $db_service->check_email($email);
	
		if($check_email == null)
			$results = 'Wprowadzone dane są niepoprawne';
		else{
			
			$password2 = $check_email->getpassword();
			$salt = $check_email->getsalt();
			$password = md5($password.$salt);
			
			if($password2 != $password)
				$results = 'Wprowadzone dane są niepoprawne';
			else{
				
				$cookie_service->set_cookie($email);
				$results = '';
			}
		}
	
		return new Response($results);
	}
	
	public function signoutAction(CookieService $cookie_service){
		
		$cookie_service->delete_user_cookie();
		
		return new RedirectResponse("/socialweb/web/app_dev.php/profil/posty");
	}
}
?>