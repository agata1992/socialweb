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

	public function indexAction(CookieService $cookie_service,DBService $db_service,Request $request,$page,$category = ''){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $request->query->get('name');
		
		$groups = $db_service->get_groups($category,$name);
	
		$groups_on_page = 6;
			
		$count_groups = count($groups);
			
		
		if((ceil($count_groups/$groups_on_page)<($page) && $page != 1) || $page <= 0)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Grupy',
			'user' => $user_data));
		
		
		return $this->render('groups.html.twig', array(
		'page_name' => 'Grupy','nav_title' => 'Grupy','user' => $user_data,'groups' => $groups,'page' => $page,'category' => $category,
		'search_input' => $name));
	}
	
	public function create_groupAction(CookieService $cookie_service,DBService $db_service,Request $request){
	
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');

			$user_data = $db_service->get_user_data();
		
			$title = $request->request->get('title');
			$description = $request->request->get('description');
			$category = $request->request->get('category');
			$type = $request->request->get('type');
	
			$results = array();
			
			if($title =='')
				$results[0] = 'Wpisz tytuł';
			elseif(strlen($title) > 50)
				$results[0] = 'Tytuł może mieć najwyżej 50 znaków';
			else
				$results[0] = '';
			
			if(strlen($description) > 255)
				$results[1] = 'Opis może mieć najwyżej 255 znaków';
			else
				$results[1] = '';
			
			if($category == '')
				$results[2] = 'Wybierz kategorię';
			else
				$results[2] = '';
			
			if($type == '')
				$results[3] = 'Wybierz typ';
			else
				$results[3] = '';
			
			if($results[0] == '' && $results[1] == '' && $results[2] == '' && $results[3] == ''){
				
				if($type == "Publiczna")
					$type = 0;
				else
					$type = 1;
				
				$last_id = $db_service->create_group($title,$description,$category,$type);
				$results[4] = $last_id;
			}
			
			return new JsonResponse($results);
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	}
	
	public function show_groupAction(CookieService $cookie_service,DBService $db_service,$id,$subpage,$page){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		
		$group = $db_service->get_group($id);
		
		if($group == NULL)
			return $this->render('page_no_found.html.twig',array(
			'page_name' => 'Nie znaleziono strony','nav_title' => 'Grupa',
			'user' => $user_data));
			
		$group_owner = $db_service->get_group_owner($id);	
		$group_users = $db_service->get_group_users($id);	
		
		for($i =0;$i<count($group_users);$i++){
			$group_users[$i]['age']=date_diff(new \DateTime(),$group_users[$i]['birthdate'])->y;
		}
		
		if($subpage == "uzytkownicy"){
			$users_on_page = 6;
			
			$count_users = count($group_users);
			print ceil($count_users/$users_on_page);
			if(((ceil($count_users/$users_on_page))<($page) && $page != 1) || $page <= 0)
				return $this->render('page_no_found.html.twig',array(
				'page_name' => 'Nie znaleziono strony','nav_title' => 'Grupa',
				'user' => $user_data));
		
		}
		
		return $this->render('group_page.html.twig', array(
		'page_name' => 'Grupa','nav_title' => 'Grupa','user' => $user_data,'group' => $group,'group_owner' => $group_owner,
		'group_users' => $group_users,'subpage' => $subpage,'page' => $page));
	}
	
	public function join_unjoin_groupAction(CookieService $cookie_service,DBService $db_service,Request $request,$id,$subpage,$page){
		
		if($request->isXmlHttpRequest() == "true"){
			
			$user = $cookie_service->check_exist_user_cookie();

			if($user == '')
				return new RedirectResponse('/socialweb/web/app_dev.php/login');
			
			$group_id = $request->request->get('group_id');
			$type = $request->request->get('type');
			
			if($type == 1)
				$db_service->join_group($group_id);
			else
				$db_service->unjoin_group($group_id);
			
			
			return new JsonResponse('');
		}
		else
			return new RedirectResponse('/socialweb/web/app_dev.php/profil/posty');
	
	}
	
}
?>