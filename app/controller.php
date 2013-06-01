<?php

//! Base controller
class Controller {

	protected $db;
	protected $cookieSalt = 'rameshsuresh';
	protected $salt = 'ahahabty';
	protected $ajax;

	//! HTTP route pre-processor
	function beforeroute($f3){
		$f3->set('loggedin',false);
		if($f3->exists('SESSION.username') && $f3->exists('SESSION.uid')){
			$f3->set('loggedin',true);
		}elseif($f3->exists('COOKIE.user')){
			$hash = explode(':', $f3->get('COOKIE.user'));
			if(count($hash)==2){
				if(sha1($this->cookieSalt.$hash[0])==$hash[1]){
					$db = $this->db;
					$query = 'SELECT id,username FROM users WHERE username=:user AND verified=1 LIMIT 1';
					$details = $db->exec($query,array(':user'=>$hash[0]));
					if(!$db->count()){
						$f3->clear('SESSION');
						$f3->clear('COOKIE.user');
					}else{
						$f3->set('SESSION.uid',$details[0]['id']);
						$f3->set('SESSION.username',$details[0]['username']);
						$f3->set('loggedin',true);
					}
				}
			}
			else{
				$f3->clear('SESSION');
				$f3->clear('COOKIE.user');
			}
		}
	}

	function setFlash($type,$message,$route=null){
		if($this->ajax){
			$vars['type'] = $type;
			$vars['message'] = $message;
			Base::instance()->set('vars',$vars);
			return;
		}
		else{
			Base::instance()->set('SESSION.messagetype',$type);
			Base::instance()->set('SESSION.message',$message);
			if($route!=''){
				Base::instance()->set('SESSION.route',$route);
				Base::instance()->reroute('/login');
			}
			Base::instance()->reroute('/');
		}
	}

	//! HTTP route post-processor
	function afterroute(){
		if(Base::instance()->get('AJAX'))
			echo Template::instance()->render('ajax.html','application/json');
		else
			echo Template::instance()->render('layout.html');
		if(Base::instance()->exists('SESSION.message')){
			Base::instance()->clear('SESSION.message');
			Base::instance()->clear('SESSION.messagetype');
		}
		if(Base::instance()->exists('SESSION.route'))
			Base::instance()->clear('SESSION.route');
	}

	//! Instantiate class
	function __construct() {
		$f3=Base::instance();
		$this->db = $f3->set('DB',
			new DB\SQL($f3->get('db'),'root','password')
		);
		$f3->set('JAR.expire',time()+60*60*24*30);
		$this->ajax = $f3->get('AJAX');
	}

}
