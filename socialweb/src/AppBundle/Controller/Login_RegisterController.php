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

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormError;

use AppBundle\Forms\Register_Form;
use AppBundle\Forms\Login_Form;

class Login_RegisterController extends Controller
{
	/*public function indexAction(CookieService $cookie_service)
	{
		$user = $cookie_service->check_exist_user_cookie();
		
		if($user != '')
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
			
		return $this->render('login.html.twig', array(
			'page_name' => 'Logowanie','user' => $user,'nav_title' => 'Zaloguj się')
		);
	}*/
	
	public function registerAction(CookieService $cookie_service,DBService $db_service,
		AdditionalService $additional_service,Request $request
	){
		
		$user = $cookie_service->check_exist_user_cookie();
		
		if($user != '')
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
		
		$register_form = new Register_Form();
		
		 $form = $this->createFormBuilder($register_form)
            ->add('name', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Imię')])
			->add('surname', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Nazwisko')])
            ->add('email', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Email')])
			->add('email2', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Powtórz email')])
			->add('password', PasswordType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Hasło')])
			->add('city', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Miasto')])
			->add('birthdate', null,['required' => false,'attr'=> array('class'=>'form-control')])
			->add('gender', ChoiceType::class, [
				'choices' => [
					'Wybierz...' => 'x',
					'Kobieta' => 'F',
					'Mężczyzna'   => 'M'
				],
				'choice_attr' => ['Wybierz...' => ['disabled'=>'','selected'=>'']],
				'attr'=> array('class'=>'form-control')
			])
			->add('register', SubmitType::class, ['label' => 'Rejestruj','attr'=> array('class'=>'btn btn-primary')])
			->getForm();
		
		$form->handleRequest($request);
			
		if ($form->isSubmitted() ){
			if($form->isValid()){
				$is_valid = true;
					
				$name = $form["name"]->getData();
				$surname = $form["surname"]->getData();
				$city = $form["city"]->getData();
				$gender = $form["gender"]->getData();
					
				if($city == null)
					$city = '';
					
				$email = $form["email"]->getData();
				$email2 = $form["email2"]->getData();
				$password = $form["password"]->getData();
					
				$birthdate = $form["birthdate"]->getData();
					
				$check_email = $db_service->check_email($email);
					
				if(!$check_email == null){
					$form->get('email')->addError(new FormError('Adres jest już w użyciu'));
					$is_valid = false;
				}
				
				if($email2 != $email){
					$form->get('email2')->addError(new FormError('Emaile nie są identyczne'));
					$is_valid = false;
				}
				
				if(!$additional_service->_s_has_upper_letters($password) ||
					!$additional_service->_s_has_lower_letters($password) ||
					!$additional_service->_s_has_numbers($password) ||
					!$additional_service->_s_has_special_chars($password)
				){
					$form->get('password')->addError(new FormError('Hasło musi zawierać dużą litere,małą,liczbę oraz znak specjalny'));
					$is_valid = false;
				}
					
				if(date("Y-m-d")<$birthdate){
					$form->get('birthdate')->addError(new FormError('Niepoprawna data'));
					$is_valid = false;
				}
				
				if($is_valid == true){
					$salt = uniqid();
					$password = $password.$salt;
					$password = md5($password);
					$db_service->add_user($name,$surname,$email,$password,$salt,$city,$birthdate,$gender);
						
					return $this->render('login_register.html.twig', array(
						'page_name' => 'Utworzono konto','user' => $user,'nav_title' => 'Utworzono konto','form' => $form->createView())
					);
				}
			}
		}
			
		return $this->render('login_register.html.twig', array(
			'page_name' => 'Rejestracja','user' => $user,'nav_title' => 'Zarejestruj się','form' => $form->createView())
		);
	}
	
	public function loginAction(CookieService $cookie_service,DBService $db_service,
		Request $request
	){
		
		$user = $cookie_service->check_exist_user_cookie();
		
		if($user != '')
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
		
		$login_form = new Login_Form();
		
		$form = $this->createFormBuilder($login_form)
			->add('email', TextType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Email')])
			->add('password', PasswordType::class,['required' => false,'attr'=> array('class'=>'form-control','placeholder' => 'Hasło')])
			->add('login', SubmitType::class, ['label' => 'Loguj','attr'=> array('class'=>'btn btn-primary')])
			->getForm();
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() ){
			if($form->isValid()){
				$email = $form["email"]->getData();
				$password = $form["password"]->getData();
			
				$is_valid = true;
			
				$check_email = $db_service->check_email($email);
			
				if($check_email != null){
					$password2 = $check_email->getpassword();
					$salt = $check_email->getsalt();
					$password = md5($password.$salt);
			
					if($password2 != $password)
						$is_valid = false;
					else{
						$cookie_service->set_cookie($email);
						
						return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
					}
				}
				else
					$is_valid = false;
			
				if($is_valid == false)
					$form->get('password')->addError(new FormError('Nieprawidłowe dane'));
			}
		}
		
		return $this->render('login_register.html.twig', array(
			'page_name' => 'Logowanie','user' => $user,'nav_title' => 'Zaloguj się','form' => $form->createView())
		);
	}
	
	public function signoutAction(CookieService $cookie_service)
	{
		$cookie_service->delete_user_cookie();
		
		return new RedirectResponse("/socialweb/web/app_dev.php/profil/posty");
	}
}