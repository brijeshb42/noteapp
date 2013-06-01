<?php

class Note extends Controller{

	function show($f3){
		$db = $this->db;
		if($f3->get('loggedin')){
			$query = 'SELECT * FROM list_items WHERE user_id='.$f3->get('SESSION.uid').' ORDER BY created DESC LIMIT 10;';
			$lists = $db->exec($query);
			if($db->count()){
				$f3->set('list',$lists);
			}
		}
		$f3->set('title','Home');
		$f3->set('inc','home.html');
		$f3->set('view','new.html');
	}

	function view($f3){
		$id = (int)$f3->get('PARAMS.id');
		if(!$id || $id==0){
			$this->setFlash('error','Invalid url.','');
		}
		$db = $this->db;
		if($f3->get('loggedin')){
			$query = 'SELECT * FROM list_items WHERE id=:itemid AND user_id=:uid LIMIT 1';
			$item = $db->exec($query,array(':itemid'=>$id,':uid'=>$f3->get('SESSION.uid')));
			//$this->setFlash('error','Login to view the note.','/note/'.$id);
		}
		else{
			$query = 'SELECT * FROM list_items WHERE id=:itemid LIMIT 1';
			$item = $db->exec($query,array(':itemid'=>$id));
		}
		if(!$db->count()){
			$this->setFlash('warning','Invalid note.','');
		}
		$f3->set('item',$item[0]);
		$f3->set('title','View Note');
		$f3->set('inc','note/view.html');
	}

	function isValidNote($f3){
		$note = $f3->get('POST.newnote');
		if(!$note || !strlen($note)){
			return false;
		}
		$uid = $f3->get('POST.user_id');
		if(!$uid || $uid!=$f3->get('SESSION.uid')){
			return false;
		}
		return true;
	}

	function add($f3){
		if(!$f3->get('loggedin')){
			$this->setFlash('warning','Please login to add new note.','/note/add');
		}
		if($f3->exists('POST')){
		if(!$f3->exists('POST.user_id') || $f3->get('POST.user_id')!=$f3->get('SESSION.uid')){
			$this->setFlash('warning','Invalid session.','');
		}
		$note = $f3->get('POST.newnote');
		$f3->scrub($note,'<b><em><u>');
		$f3->encode($note);
		if(!$note || !strlen($note)){
			$this->setFlash('error','Something is needed in the note.','');
			//$f3->set('error_note','Something is needed in the note.');
		}else{
			$db = $this->db;
			$notes = new DB\SQL\Mapper($db,'list_items');
			$notes->item_text = $note;//nl2br($note);
			$notes->user_id = $f3->get('SESSION.uid');
			//print_r($notes);
			if($notes->save()){
				$this->setFlash('success',$notes->_id,'');
			}
			else{
				$this->setFlash('error','Error while saving note.','');
			}
		}
		}
		$f3->set('title','Add Note');
		$f3->set('inc','home.html');
		$f3->set('view','new.html');
	}

	function newnote($f3){
		if(!$f3->get('loggedin')){
			$this->setFlash('warning','Please login to add new note.','/note/add');
		}
		else{
		if(!$f3->exists('POST.user_id') || $f3->get('POST.user_id')!=$f3->get('SESSION.uid')){
			$this->setFlash('warning','Invalid session.','');
		}
		$note = $f3->get('POST.newnote');
		$f3->encode($note);
		if(!$note || !strlen($note)){
			$this->setFlash('error','Something is needed in the note.','');
			//$f3->set('error_note','Something is needed in the note.');
		}else{
			$db = $this->db;
			$notes = new DB\SQL\Mapper($db,'list_items');
			$notes->item_text = $note;//nl2br($note);
			$notes->user_id = $f3->get('SESSION.uid');
			//print_r($notes);
			if($notes->save()){
				$this->setFlash('success',$notes->_id,'');
			}
			else{
				$this->setFlash('error','Error while saving note.','');
			}
		}
		}
		$f3->set('title','Add Note');
		$f3->set('inc','home.html');
		$f3->set('view','new.html');
	}

	function changecolor($f3){
		//$f3->set('title','Change Color');
		//$f3->set('inc','home.html');
	}

	function edit($f3){
		$url = '/note/edit/';
		if($f3->exists('PARAMS.id') && (int)$f3->get('PARAMS.id')){
			$id = $f3->get('PARAMS.id');
			$url = $url.$id;
		}
		else{
			$this->setFlash('warning','Invalid url.','');
		}
		if(!$f3->get('loggedin')){
			$this->setFlash('warning','Please login to edit the note.',$url);
		}
		$id = (int)($f3->get('PARAMS.id'));
		if(!$id){
			$this->setFlash('warning','Invalid note.','');
		}
		$db = $this->db;
		if($f3->exists('POST.newnote')){
			if($this->isValidNote($f3)){
				//$f3->set('error_note','Something is needed in the note.');
				$query = 'UPDATE  list_items SET  item_text = :text WHERE  id = :itemid AND user_id=:uid';
				$note = $f3->get('POST.newnote');
				$itemid = (int)$f3->get('POST.item_id');
				//$note = nl2br($note);
				$f3->encode($note);
				$item = $db->exec($query,array(':text'=>$note,':itemid'=>$itemid,':uid'=>$f3->get('SESSION.uid')));
				if($item){
					$this->setFlash('success','Note updated.','');
				}
				else{
					$this->setFlash('error','Note not updated.','');
				}
			}else{
				$this->setFlash('error','Something is needed in the note.','');
			}
		}

		$query = 'SELECT * FROM list_items WHERE id='.$id.' AND user_id='.$f3->get('SESSION.uid').' LIMIT 1';
		$item = $db->exec($query);
		if(!$db->count()){
			$this->setFlash('warning','Invalid note.','');
		}
		$f3->set('item',$item[0]);
		$f3->set('title','Edit Note');
		$f3->set('inc','home.html');
		$f3->set('view','edit.html');
	}

	function delete($f3){
		$id = (int)$f3->get('PARAMS.id');
		if(!$f3->get('loggedin')){
			$this->setFlash('warning','Please login to delete the note.','');
		}
		if(!$id){
			$this->setFlash('error','Invalid note.');
		}
		else{
			$db = $this->db;
			$query = 'DELETE FROM list_items WHERE id=:id AND user_id=:uid';
			$res = $db->exec($query,array(':id'=>$id,':uid'=>$f3->get('SESSION.uid')));
			if($res){
				$this->setFlash('success','Note deleted.','');
			}
			else{
				$this->setFlash('error','Invalid note.','');
			}
		}
	}

	function error($f3){
		$log=new Log('error.log');
		$log->write($f3->get('ERROR.text'));
		foreach ($f3->get('ERROR.trace') as $frame)
			if (isset($frame['file'])) {
				$line='';
				$addr=$f3->fixslashes($frame['file']).':'.$frame['line'];
				if (isset($frame['class']))
					$line.=$frame['class'].$frame['type'];
				if (isset($frame['function'])) {
					$line.=$frame['function'];
					if (!preg_match('/{.+}/',$frame['function'])) {
						$line.='(';
						if (isset($frame['args']) && $frame['args'])
							$line.=$f3->csv($frame['args']);
						$line.=')';
					}
				}
				$log->write($addr.' '.$line);
			}
		//$f3->set('SESSION.messagetype','error');
		//$f3->set('SESSION.message','Something is fishy with that url.');
		header('HTTP/1.1 '.$f3->get('ERROR.code'));
		header('Content-Type: text/plain');
		echo($f3->get('ERROR.text'));
		//$f3->reroute('/');
	}

}
