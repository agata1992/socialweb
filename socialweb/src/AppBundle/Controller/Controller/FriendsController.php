<?php
	
namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;


class FriendsController extends Controller{
	
	public function add_to_friendsAction(CookieService $cookie_service,DBService $db_service,Request $request){
		if($request->isXmlHttpRequest() == "true"){
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
			$friend_id = $request->request->get('friend_id');
			
			$db_service-> invitations($friend_id);
	
			return new JsonResponse('');
		}
	}
	
	public function delete_friendAction(CookieService $cookie_service,DBService $db_service,Request $request){
		if($request->isXmlHttpRequest() == "true"){
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
			$friend_id = $request->request->get('friend_id');
			
			$db_service-> delete_friend($friend_id);
	
			return new JsonResponse('');
		}
	}
	
}
?>