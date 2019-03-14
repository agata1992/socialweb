<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;
use AppBundle\Service\AdditionalService;

class GroupsController extends Controller{

	public function indexAction(CookieService $cookie_service,DBService $db_service){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		return $this->render('groups.html.twig', array(
			'page_name' => 'Grupy','nav_title' => 'Grupy','user' => $user_data));

	}
	
	
}
?>