<?php
	
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;

class CommentsController extends Controller
{
	public function add_image_commmentAction(CookieService $cookie_service,
		DBService $db_service,Request $request,$image_id
	){
		if($request->isXmlHttpRequest() == "true"){
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
			$type = $request->request->get('type');
			$image_comment_input = $request->get('comment_input');
			
			$comment_id = '';
			
			if($type == 0)
				$comment_id = $request->request->get('comment_id');
			
			$results = '';
			
			if($image_comment_input == '')
				$results = 'Komentarz nie może być pusty';
			else
				$db_service->add_image_commment($type,$image_comment_input,$image_id,
					$comment_id
				);
			
			return new JsonResponse($results);
		}
	}
	
	public function add_group_commmentAction(CookieService $cookie_service,
		DBService $db_service,Request $request,$id
	){
		if($request->isXmlHttpRequest() == "true"){
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
			$type = $request->request->get('type');
			$group_comment_input = $request->get('comment_input');
			
			$comment_id = '';
			
			if($type == 0)
				$comment_id = $request->request->get('comment_id');
			
			$results = '';
			
			if($group_comment_input == '')
				$results = 'Komentarz nie może być pusty';
			else
				$db_service->add_group_commment($type,$group_comment_input,$id,$comment_id);
			
			return new JsonResponse($results);
		}
	}
}