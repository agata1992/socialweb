<?php
	
namespace AppBundle\Service;
	
class FileService{
	
	public function save_user_image($image){
		$results = array();
		$extensions=array('jpg','jpe','jpeg','jfif','png','bmp','dib','gif');
		if(in_array(pathinfo($image['name'])['extension'], $extensions)){
			$tmp=$image['tmp_name'];
			$org=$image['name'];
			$name=pathinfo($tmp)['filename'].".";
			$name.=pathinfo($org)['extension'];
			if(!move_uploaded_file($tmp,'images/'.$name)){
				$results[0] = "Wystąpił błąd";
			}
			else{
				$results[0] = '';	
			}
			
			$results[1] = $name;
		}
		else
			$results[0] = "Proszę wybrać obraz";
	
		return $results;
	}	
	
	public function remove_user_image($image){
		unlink('images/'.$image);
	}
}	
	
	
	
	
	
	
?>