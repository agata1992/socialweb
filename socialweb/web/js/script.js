window.onload = function(event) {
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil/posty") ||
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/posty")){
		
		$('#title-posts').addClass( "log-reg-title-active" );
		$('#title-posts').removeClass( "pointer" );
	
		$('#title-profile').removeClass( "log-reg-title-active" );
		$('#title-profile').addClass( "pointer" );
	
		$('#title-friends').removeClass( "log-reg-title-active" );
		$('#title-friends').addClass( "pointer" );
	
		$('#title-galery').removeClass( "log-reg-title-active" );
		$('#title-galery').addClass( "pointer" );
	
		$("#con-posts").show();
		$("#con-profile").hide();
		$("#con-friends").hide();
		$("#con-galery").hide();
		$("#con-image").hide();
		$("#con-album").hide();
	}
	
	if(window.location.pathname == "/socialweb/web/app_dev.php/profil/omnie" ||
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/omnie")
	){
		
		$('#title-profile').addClass( "log-reg-title-active" );
		$('#title-profile').removeClass( "pointer" );
	
		$('#title-friends').removeClass( "log-reg-title-active" );
		$('#title-friends').addClass( "pointer" );
	
		$('#title-posts').removeClass( "log-reg-title-active" );
		$('#title-posts').addClass( "pointer" );
	
		$('#title-galery').removeClass( "log-reg-title-active" );
		$('#title-galery').addClass( "pointer" );
	
		$("#con-profile").show();
		$("#con-posts").hide();
		$("#con-friends").hide();
		$("#con-galery").hide();
		$("#con-album").hide();
		$("#con-image").hide();
	}
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/profil/znajomi") ||
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/znajomi")){
		$('#title-friends').addClass( "log-reg-title-active" );
		$('#title-friends').removeClass( "pointer" );
	
		$('#title-posts').removeClass( "log-reg-title-active" );
		$('#title-posts').addClass( "pointer" );
	
		$('#title-profile').removeClass( "log-reg-title-active" );
		$('#title-profile').addClass( "pointer" );
	
		$('#title-galery').removeClass( "log-reg-title-active" );
		$('#title-galery').addClass( "pointer" );
	
		$("#con-friends").show();
		$("#con-posts").hide();
		$("#con-profile").hide();
		$("#con-galery").hide();
		$("#con-album").hide();
		$("#con-image").hide();
		
		originalValue = $('#search-friends-input').val();
		$('#search-friends-input').val('');
		$('#search-friends-input').blur().focus().val(originalValue)
	}
	
	if(window.location.pathname == "/socialweb/web/app_dev.php/profil/galeria" ||
	window.location.pathname.match("/socialweb/web/app_dev.php/profil/galeria/[0-9]*") ||
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/galeria")){
	
		$('#title-galery').addClass( "log-reg-title-active" );
		$('#title-galery').removeClass( "pointer" );
	
		$('#title-friends').removeClass( "log-reg-title-active" );
		$('#title-friends').addClass( "pointer" );
	
		$('#title-posts').removeClass( "log-reg-title-active" );
		$('#title-posts').addClass( "pointer" );
	
		$('#title-profile').removeClass( "log-reg-title-active" );
		$('#title-profile').addClass( "pointer" );
	
		$("#con-galery").show();
		$("#con-posts").hide();
		$("#con-profile").hide();
		$("#con-friends").hide();
		$("#con-album").hide();
		$("#con-image").hide();
	}
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil/galeria/album") || 
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/galeria/album")) {
	
		$('#title-galery').addClass( "log-reg-title-active" );
		$('#title-galery').removeClass( "pointer" );
	
		$('#title-friends').removeClass( "log-reg-title-active" );
		$('#title-friends').addClass( "pointer" );
	
		$('#title-posts').removeClass( "log-reg-title-active" );
		$('#title-posts').addClass( "pointer" );
	
		$('#title-profile').removeClass( "log-reg-title-active" );
		$('#title-profile').addClass( "pointer" );
	
		$("#con-galery").hide();
		$("#con-posts").hide();
		$("#con-profile").hide();
		$("#con-friends").hide();
		$("#con-image").hide();
		$("#con-album").show();
	}
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/profil/galeria/album/[0-9]*/zdjecie") ||
	window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/galeria/album/[0-9]*/zdjecie")) {
	
		$('#title-galery').addClass( "log-reg-title-active" );
		$('#title-galery').removeClass( "pointer" );
	
		$('#title-friends').removeClass( "log-reg-title-active" );
		$('#title-friends').addClass( "pointer" );
	
		$('#title-posts').removeClass( "log-reg-title-active" );
		$('#title-posts').addClass( "pointer" );
	
		$('#title-profile').removeClass( "log-reg-title-active" );
		$('#title-profile').addClass( "pointer" );
	
		$("#con-galery").hide();
		$("#con-posts").hide();
		$("#con-profile").hide();
		$("#con-friends").hide();
		$("#con-album").hide();
		$("#con-image").show();
		$("#setting-image-div").show();
	}
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/profil/galeria/album/[0-9]*/page") &&
		!window.location.pathname.match("/socialweb/web/app_dev.php/profil/galeria/album/[0-9]*/page/[0-9]*")){
		window.location.pathname = window.location.pathname + "/1";
	}
	
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/wyszukiwarka")){
		if($('#gender-select').val() == 'Kobieta' || $('#gender-select').val() == 'Mężczyzna')
			$('#select-gender-delete').show();
	}
}


$("#row-reg1").hide();
$("#row-reg2").hide();
$("#row-reg3").hide();
$("#row-reg4").hide();
$("#row-reg5").hide();
$('#container2').removeClass( "d-flex" );
$("#container2").css('display', 'none');

$("#dropdown-nav1").css('top', $("#nav1").height()+20);
$("#image-feedback").hide();
$("#album-name-feedback").hide();
$("#add-album-feedback").hide();

$("#replay-image-comment-div").hide();


$('#add-image').change(function(){
	$('#upload-form').submit();
});

$("#upload-form").submit(function(e) {
	e.preventDefault();
	var data=new FormData(this);
	var request = $.ajax({
		url:window.location.pathname+"/upload",
		type: "POST",
		datatype: "json",
		data:  data,
		contentType: false,
		processData: false
	});   
	
	request.done(function(results){  
		if(results == '')
			location.reload();
		else{
			$("#image-feedback").html(results[0]);
			$("#image-feedback").show();
		}
	});
});


window.onresize = function(event) {
	$("#dropdown-nav1").css('top', $("#nav1").height()+20);
};

$('#title-log').click(function (event) {
	$('#title-log').addClass( "log-reg-title-active" );
	$('#title-reg').removeClass( "log-reg-title-active" );
	$('#title-log').removeClass( "pointer" );
	$('#title-reg').addClass( "pointer" );
	$("#row-log1").css('display', 'block');
	$("#row-log2").css('display', 'block');
	$("#row-log3").css('display', 'block');
	
	$("#row-reg1").hide();
	$("#row-reg2").hide();
	$("#row-reg3").hide();
	$("#row-reg4").hide();
	$("#row-reg5").hide();
});

$("#title-reg").click(function() {
	$('#title-reg').addClass( "log-reg-title-active" );
	$('#title-log').removeClass( "log-reg-title-active" );
	$('#title-reg').removeClass( "pointer" );
	$('#title-log').addClass( "pointer" );
	$("#row-log1").css('display', 'none');
	$("#row-log2").css('display', 'none');
	$("#row-log3").css('display', 'none');
	
	$("#row-reg1").show();
	$("#row-reg2").show();
	$("#row-reg3").show();
	$("#row-reg4").show();
	$("#row-reg5").show();
});

$('#title-posts').click(function (event) {alert(window.location.pathname);
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil")){
		if(window.location.pathname != "/socialweb/web/app_dev.php/profil/posty")
			window.location.pathname = "/socialweb/web/app_dev.php/profil/posty";
	}
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/user")){
		location_ = window.location.pathname;
		match_ = location_.match("/socialweb/web/app_dev.php/user/[0-9]*");
		user_id = match_.toString().replace("/socialweb/web/app_dev.php/user/","");
		
		if(!window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/posty"))
			window.location.pathname = "/socialweb/web/app_dev.php/user/"+user_id+"/posty";
	}
	
});

$('#title-profile').click(function (event) {

	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil")){
		if (window.location.pathname != "/socialweb/web/app_dev.php/profil/omnie")
			window.location.pathname = "/socialweb/web/app_dev.php/profil/omnie";
	}
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/user")){
		location_ = window.location.pathname;
		match_ = location_.match("/socialweb/web/app_dev.php/user/[0-9]*");
		user_id = match_.toString().replace("/socialweb/web/app_dev.php/user/","");
		
		if(!window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/omnie"))
			window.location.pathname = "/socialweb/web/app_dev.php/user/"+user_id+"/omnie";
	}
	
});


$('#title-friends').click(function (event) {
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil")){
		if (window.location.pathname != "/socialweb/web/app_dev.php/profil/znajomi")
			window.location.pathname = "/socialweb/web/app_dev.php/profil/znajomi";
	}
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/user")){
		location_ = window.location.pathname;
		match_ = location_.match("/socialweb/web/app_dev.php/user/[0-9]*");
		user_id = match_.toString().replace("/socialweb/web/app_dev.php/user/","");
		
		if(!window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/znajomi"))
			window.location.pathname = "/socialweb/web/app_dev.php/user/"+user_id+"/znajomi";
	}
});

$('#title-galery').click(function (event) {
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/profil")){
		if (window.location.pathanme != "/socialweb/web/app_dev.php/profil/galeria")
			window.location.pathname = "/socialweb/web/app_dev.php/profil/galeria";
	}
	
	if(window.location.pathname.includes("/socialweb/web/app_dev.php/user")){
		location_ = window.location.pathname;
		match_ = location_.match("/socialweb/web/app_dev.php/user/[0-9]*");
		user_id = match_.toString().replace("/socialweb/web/app_dev.php/user/","");
		
		if(!window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/galeria"))
			window.location.pathname = "/socialweb/web/app_dev.php/user/"+user_id+"/galeria";
	}
	
	
});

$("#image-comments-replay-button").click(function() {
	if($('#replay-image-comment-div').is(':hidden'))
		$('#replay-image-comment-div').show();
	else
		$('#replay-image-comment-div').hide();
	});

function Register(){
	var name = document.getElementById("reg-name").value;
	var surname = document.getElementById("reg-surname").value;
	var email = document.getElementById("reg-email1").value;
	var email2 = document.getElementById("reg-email2").value;
	var password = document.getElementById("reg-pass").value;
	var city = document.getElementById("reg-city").value;
	var birthdate = document.getElementById("reg-birthdate").value;
	var gender = document.getElementById("reg-gender").value;
	
	var data='&name='+name+'&surname='+surname+'&email='+email+
	'&email2='+email2+'&password='+password+'&city='+city+'&birthdate='+birthdate
	+'&gender='+gender;
	
	var request= $.ajax({
		url:"login/rejestracja",
		type:"POST",
		datatype:"json",
		data:data			
	});
		
	request.done(function(results){
		$('#reg-name').removeClass( "is-invalid" );
		$('#reg-surname').removeClass( "is-invalid" );
		$('#reg-email1').removeClass( "is-invalid" );
		$('#reg-email2').removeClass( "is-invalid" );
		$('#reg-pass').removeClass( "is-invalid" );
		$('#reg-birthdate').removeClass( "is-invalid" );
		$('#reg-gender').removeClass( "is-invalid" );
		
		$('#col-reg-name .invalid-feedback').html('');
		$('#col-reg-surname .invalid-feedback').html('');
		$('#col-reg-email .invalid-feedback').html('');
		$('#col-reg-email2 .invalid-feedback').html('');
		$('#col-reg-pass .invalid-feedback').html('');
		$('#col-reg-birthdate .invalid-feedback').html('');
		$('#col-reg-gender .invalid-feedback').html('');
		
		if(results[0]!=''){
			$('#col-reg-name .invalid-feedback').html(results[0]);
			$('#reg-name').addClass( "is-invalid" );
		}
		
		if(results[1]!=''){
			$('#col-reg-surname .invalid-feedback').html(results[1]);
			$('#reg-surname').addClass( "is-invalid" );
		}
		
		if(results[2]!=''){
			$('#col-reg-email .invalid-feedback').html(results[2]);
			$('#reg-email1').addClass( "is-invalid" );
		}
		
		if(results[3]!=''){
			$('#col-reg-email2 .invalid-feedback').html(results[3]);
			$('#reg-email2').addClass( "is-invalid" );
		}
		
		if(results[4]!=''){
			$('#col-reg-pass .invalid-feedback').html(results[4]);
			$('#reg-pass').addClass( "is-invalid" );
		}
		
		if(results[5]!=''){
			$('#col-reg-birthdate .invalid-feedback').html(results[5]);
			$('#reg-birthdate').addClass( "is-invalid" );
		}
		
		if(results[6]!=''){
			$('#col-reg-gender .invalid-feedback').html(results[6]);
			$('#reg-gender').addClass( "is-invalid" );
		}
		
		if(results[0] == '' && results[1] == '' && results[2] == '' && results[3] == '' 
		&& results[4] == '' && results[5] == '' && results[6] == ''){
			$('#container2').addClass( "d-flex" );
			$("#container1").removeClass( "d-flex" );
			$("#container1").css('display', 'none');
		}
	});
}
	
function Login(){
	var email = document.getElementById("log-email").value;
	var password = document.getElementById("log-pass").value;
	var data='&email='+email+'&password='+password;
	
	var request= $.ajax({
		url:"login/logowanie",
		type:"POST",
		datatype:"json",
		data:data			
	});
	
	request.done(function(results){
		$('#log-pass').removeClass( "is-invalid" );
		$('#col-log-pass .invalid-feedback').html('');
		
		if(results[0] != ''){
			$('#col-log-pass .invalid-feedback').html(results[0]);
			$('#log-pass').addClass( "is-invalid" );
		}
		else{
			window.location.href = "/socialweb/web/app_dev.php/profil/posty";
		}
	});
}

function change_album_access(name){
	current_active = $('#album_access .active').attr('name');
	$('#album_access [name="'+current_active+'"]').removeClass('active');
	$('#album_access [name="'+name+'"]').addClass('active');	

	if(current_active != name){
		var data = '&album_access='+name;
	
		var request= $.ajax({
			url: window.location.pathname+"/dostep",
			type: "POST",
			datatype: "json",
			data: data			
		});
	}
}

function change_album_name(){
	new_album = $('#new_album_name').val();
	var data = '&name='+new_album;
	
	var request = $.ajax({
		url: window.location.pathname+"/zmien-nazwe-albumu",
		type: "POST",
		datatype: "json",
		data: data
	});   
	request.done(function(results){  
		if(results == '')
			location.reload();
		else{
			$("#album-name-feedback").html(results);
			$("#album-name-feedback").show();
		}
	});
}

function add_album(){
	new_album = $('#new_album').val();
	var data='&name='+new_album;
	
	if(!window.location.pathname.match("/socialweb/web/app_dev.php/profil/galeria/[0-9]*"))
		$url = window.location.pathname+"/1/dodaj-album";
	else
		$url = window.location.pathname+"/dodaj-album";
	
	
	var request = $.ajax({
		url: $url,
		type: "POST",
		datatype: "json",
		data: data
	});   
	request.done(function(results){ 
		if(results == '')
			location.reload();
		else{
			$("#add-album-feedback").html(results);
			$("#add-album-feedback").show();
		}
	});
}

function delete_album(){
	$('#decision-modal .modal-body p').html("Czy chcesz usunąć album wraz ze zdjęciami?")
	$('#decision-modal').addClass('delete-album-modal');
	$('.delete-album-modal').show();
	
	$(".delete-album-modal .modal-header .close").click(function() {
		$('.delete-album-modal').hide();
	});
	
	$(".delete-album-modal .modal-footer #button_cancel").click(function() {
		$('.delete-album-modal').hide();
	});
	
	$(".delete-album-modal .modal-footer #button_confirm").click(function() {
		var request = $.ajax({
			url: window.location.pathname+"/usun-album",
			type: "POST",
			datatype: "json"
		});   
	
		request.done(function(results){  
			$('.delete-album-modal').hide(); 
			window.location.href = "/socialweb/web/app_dev.php/profil/galeria";
		});
	});
}

function edit_image_description(){
	$('#edit-image-description-modal').show();
	
	$("#edit-image-description-modal .modal-header .close").click(function() {
		$('#edit-image-description-modal').hide();
	});
	$("#edit-image-description-modal .modal-footer #button_cancel").click(function() {
		$('#edit-image-description-modal').hide();
	});
	
	$("#edit-image-description-modal .modal-footer #button_confirm").click(function() {
		var description = $('#img-description').val();
		var data='&description='+description;
		var request = $.ajax({
			url: window.location.pathname+"/edytuj_opis",
			type: "POST",
			datatype: "json",
			data: data
		});
	
		request.done(function(results){  
			if(results == ''){
				$('#edit-image-description-modal').hide(); 
				location.reload();
			}
			else{
				$('#edit-image-description-feedback').html(results);
			}
		});
	});
}

function delete_image(){
	$('#decision-modal .modal-body p').html("Czy chcesz usunąć zdjęcie?")
	$('#decision-modal').addClass('delete-image-modal');
	$('.delete-image-modal').show();
	
	$(".delete-image-modal .modal-header .close").click(function() {
		$('.delete-image-modal').hide();
	});
	
	$(".delete-image-modal .modal-footer #button_cancel").click(function() {
		$('.delete-image-modal').hide();
	});
	
	$(".delete-image-modal .modal-footer #button_confirm").click(function() {
		var request = $.ajax({
			url: window.location.pathname+"/usun-zdjecie",
			type: "POST",
			datatype: "json"
		});   
	
		request.done(function(results){  
			$('.delete-image-modal').hide(); 
			path = window.location.pathname;
			index = path.indexOf('zdjecie');
			window.location.href = path.substring(0,index-1);
		});
	});
}
	
function set_as_profile_img(){
	$('#decision-modal .modal-body p').html("Czy chcesz ustawić zdjęcie jako profilowe?")
	$('#decision-modal').addClass('profile-image-modal');
	$('.profile-image-modal').show();
	
	$(".profile-image-modal .modal-header .close").click(function() {
		$('.profile-image-modal').hide();
	});
	
	$(".profile-image-modal .modal-footer #button_cancel").click(function() {
		$('.profile-image-modal').hide();
	});
	
	$(".profile-image-modal .modal-footer #button_confirm").click(function() {
		var request = $.ajax({
			url: window.location.pathname+"/profilowe",
			type: "POST",
			datatype: "json"
		});   
	
		request.done(function(results){  
			$('profile-image-modal').hide(); 
			location.reload();
		});
	});
}

function add_to_friends(friend_id){
	var data='&friend_id='+friend_id;

	if(window.location.pathname == '/socialweb/web/app_dev.php/wyszukiwarka')
		url = window.location.pathname+ "/1/add-to-friends";
	else if(window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/[a-z]*")){
		if(window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/[a-z]*/[0-9]*") == null)
			url = window.location.pathname+ "/1/add-to-friends";
		else
			url = window.location.pathname+ "/add-to-friends";
	}	
	var request = $.ajax({
		url: url,
		type: "POST",
		datatype: "json",
		data: data
	});
	 
	request.done(function(){  
		location.reload();
	});
}


function delete_friend(friend_id){
	var data='&friend_id='+friend_id;
	
	$('#decision-modal .modal-body p').html("Czy chcesz użytkownika?")
	$('#decision-modal').addClass('delete-friend-modal');
	$('.delete-friend-modal').show();
	
	$(".delete-friend-modal .modal-header .close").click(function() {
		$('.delete-friend-modal').hide();
	});
	
	$(".delete-friend-modal .modal-footer #button_cancel").click(function() {
		$('.delete-friend-modal').hide();
	});
	
	if(window.location.pathname == '/socialweb/web/app_dev.php/profil/znajomi')
		url = '/socialweb/web/app_dev.php/profil/znajomi/1/delete-friend'
	else
		url = window.location.pathname + "/delete-friend";
	
	$(".delete-friend-modal .modal-footer #button_confirm").click(function() {
		var request = $.ajax({
			url: url,
			type: "POST",
			datatype: "json",
			data: data
		});   
	
		request.done(function(){  
			$('.delete-friend-modal').hide(); 
			location.reload();
		});
	});
}




$('#range1').change(function(){
	if($('#range-input2').val() == '')
		$('#range-input1').val($('#range1').val());
	else{
		if($('#range1').val() <= $('#range2').val())
			$('#range-input1').val($('#range1').val());
		else
			$('#range1').val($('#range-input1').val());
	}
});

$('#range2').change(function(){
	if($('#range-input1').val() == '')
		$('#range-input2').val($('#range2').val());
	else{
		if($('#range2').val() >= $('#range1').val())
			$('#range-input2').val($('#range2').val());
		else
			$('#range2').val($('#range-input2').val());
		}
});

$('#gender-select').change(function(){
	if($('#gender-select').val() == 'Kobieta' || $('#gender-select').val() == 'Mężczyzna')
		$('#select-gender-delete').show();
});

$('#select-gender-delete').click(function (event) {
	$('#gender-select').val('Płeć');
	$('#select-gender-delete').hide();
});

$('#search-friends-input').on('keyup', function(){
	search_friends_input = $('#search-friends-input').val();
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/znajomi")){
		match_ = window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*");
		user_id = match_.toString().replace("/socialweb/web/app_dev.php/user/","");
	}
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/profil/znajomi"))
		url = "/socialweb/web/app_dev.php/profil/znajomi";
	
	if(window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/znajomi"))
		url = window.location.pathname.match("/socialweb/web/app_dev.php/user/[0-9]*/znajomi");
	
	var form = $('<form action="' +url + '" method="post" id="friends_search">' +
	'<input type="hidden" value="' +search_friends_input + '" name="search_friends_input"/></form>');
	
	$('#con-friends').append(form);
	$("#friends_search").submit();
});
