<?php

class User extends Controller{

	private function isValidUser($user){
	}

	function login($f3){
		if($f3->get('loggedin')==true)
			$f3->reroute('/');
		$f3->set('title','Login');
		$f3->set('inc','user/login.html');
	}

	function auth($f3){
		$f3->clear('SESSION');
		$username = trim($f3->get('POST.username'));
		$pass = trim($f3->get('POST.password'));
		if(!$f3->exists('POST.username') || !strlen($username))
			$f3->set('error_username','Provide username.');
		if(!$f3->exists('POST.password') || !strlen($pass))
			$f3->set('error_password','Enter password.');
		$f3->scrub($username);
		$f3->scrub($pass);
		if(!($f3->exists('error_username') || $f3->exists('error_password'))){
			$db = $this->db;
			$query = 'SELECT username,id FROM users WHERE (username=:user OR email=:em) AND password=:pass AND verified=1 LIMIT 1';
			$details = $db->exec($query,array(':user'=>$username,':em'=>$username,':pass'=>sha1($this->salt.$pass)));
			if(!$db->count()){
				//print_r($f3);
				$f3->set('error_username','Wrong username or password.');
			}else{
				$f3->set('SESSION.username',$details[0]['username']);
				$f3->set('SESSION.uid',$details[0]['id']);
				if($f3->exists('POST.rememberme') && $f3->get('POST.rememberme')==1){
					$hash = $details[0]['username'].':'.sha1($this->cookieSalt.$username);
					$f3->set('COOKIE.user',$hash);
				}
				//$f3->set('SESSION.messagetype','success');
				//$f3->set('SESSION.message','You have successfully logged in.');
				if($f3->exists('POST.route'))
					$f3->reroute($f3->get('POST.route'));
				$f3->reroute('/');
			}
		}
		$f3->set('title','Login');
		$f3->set('inc','user/login.html');
	}

	function logout($f3){
		$f3->clear('SESSION');
		$f3->clear('COOKIE.user');
		$f3->reroute('/');
	}

	function signup($f3){
		if($f3->get('loggedin')==true)
			$f3->reroute('/');
		$f3->set('title','Signup');
		$f3->set('inc','user/signup.html');
	}

	function account($f3){
		if(!$f3->get('loggedin')){
			$this->setFlash('warning','Please login to add new note.','/account');
		}
		$f3->set('title','My Account');
		$f3->set('inc','user/account.html');
	}

	function register($f3){
		$username = trim($f3->get('POST.username'));
		$email = trim($f3->get('POST.email'));
		$pass = trim($f3->get('POST.password'));
		$cpass = trim($f3->get('POST.cpassword'));
		$f3->scrub($username);
		$f3->scrub($email);
		$f3->scrub($pass);
		$f3->scrub($cpass);

		$db = $this->db;
		$users = new DB\SQL\Mapper($db,'users');
		$user_email = new DB\SQL\Mapper($db,'users');
		$users->load(array('username=?',$username));
		$user_email->load(array('email=?',$email));

		if(!$f3->exists('POST.username') || !strlen($username))
			$f3->set('error_username','Username is required.');
		else if(!preg_match('/^[a-zA-Z](\w){4,}$/', $username))
			$f3->set('error_username','Username not valid.');
		else if(!$users->dry())
			$f3->set('error_username','Username already exists.');

		if(!$f3->exists('POST.email') || !strlen($email))
			$f3->set('error_email','Email required.');
		elseif (!$user_email->dry())
			$f3->set('error_email','Email already exists.');
		//elseif (!Audit::instance()->email($f3->get('POST.email'))) {
		//	$f3->set('error_email','Invalid email.');
		//}
		if(!$f3->exists('POST.password') || !strlen($pass) || !$f3->exists('POST.cpassword') || !strlen($cpass))
			$f3->set('error_password','Both passwords are required.');
		else if(strlen($pass)<6){
			$f3->set('error_password','Password should be of minimum 6 characters.');
		}
		else if($pass!=$cpass)
			$f3->set('error_password','Passwords do not match.');

		if(!($f3->exists('error_username') || $f3->exists('error_email') || $f3->exists('error_password'))){
			if($users->dry() && $user_email->dry()){
				$users->username = $username;
				$users->email = $email;
				$users->password = sha1($this->salt.$pass);
				$users->ver_code = sha1(time().$pass);
				if($users->save()){
					$this->setFlash('success','You have been successfully registered.','');
				}
				else{
					$this->setFlash('error','There was some error.','');
				}
			}
		}
		$f3->set('title','Signup');
		$f3->set('inc','user/signup.html');
	}

	function changepass($f3){

	}

	function delete($f3){

	}

}
