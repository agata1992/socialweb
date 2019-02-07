<?php

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Constraints\DateTime;
use AppBundle\Service\CookieService;
use AppBundle\Service\DBService;

class SearchController extends Controller{
	public function indexAction(CookieService $cookie_service,DBService $db_service,Request $request,$page){
		
		$user = $cookie_service->check_exist_user_cookie();

		if($user == '')
			return new RedirectResponse('/socialweb/web/app_dev.php/login');

		$user_data = $db_service->get_user_data();
		$name = $request->query->get('name');
		$city = $request->query->get('city');
		$gender = $request->query->get('gender');
		$min_age = $request->query->get('min_age');
		$max_age = $request->query->get('max_age');
		
		if($name != ''){
			$searched_users=$db_service->search_users($name,$city,$gender);
			$users_on_page =9;
			$count_users = count($searched_users);
			
			if($min_age == '')
				$tmp_min_age = 0;
			else
				$tmp_min_age = $min_age;
			if($max_age == '')
				$tmp_max_age = 100;
			else
				$tmp_max_age = $max_age;
			
			for($i = 0;$i < $count_users;$i++){
				$searched_users[$i]->age=date_diff(new \DateTime(),$searched_users[$i]->getbirthdate())->y;
				$friendship = $db_service->check_friend($searched_users[$i]);
				$searched_users[$i]->friendship = $friendship;
				
				if(!($searched_users[$i]->age >=$tmp_min_age && $searched_users[$i]->age <=$tmp_max_age))
					unset($searched_users[$i]);
			}
		}
		else
			$searched_users = null;
		
		return $this->render('search.html.twig', array(
		'page_name' => 'Wyszukiwarka','nav_title' => 'Szukaj','user' => $user_data,"searched_users" => $searched_users,
		'searcher_user_name' => $name,'searcher_user_city' => $city,'searcher_user_gender' => $gender,'searcher_user_min_age' => $min_age,
		'searcher_user_max_age' => $max_age,'page' => $page));
	}
}

?>
