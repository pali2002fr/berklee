<?php

	function getFolders() {
		$_return = array();
		$db = new PDO('mysql:host=localhost;dbname=berklee;charset=utf8', 'root', 'root');
   		$stmt = $db->query("SELECT i.id, i.parent_id, i.name FROM folders f INNER JOIN items i ON f.id = i.id");
   		$_return = $stmt->fetchAll(PDO::FETCH_ASSOC);
   		return $_return;
	}

	function getDocuments() {
		$_return = array();
		$db = new PDO('mysql:host=localhost;dbname=berklee;charset=utf8', 'root', 'root');
   		$stmt = $db->query("SELECT i.id, i.parent_id, i.name FROM documents d INNER JOIN items i ON i.id = d.id");
   		$_return = $stmt->fetchAll(PDO::FETCH_ASSOC);
   		return $_return;
	}

class f {
	public $f_list = array();	
	public function the_processing_function($id, $data){
		foreach ($data as $key => $value){	

			if($value['parent_id'] == $id){
				$this->f_list[$value['id']] = $value['name'];
				$this->the_processing_function($value['id'], $data);
			}
		}
	}
	public function get_r(){
		return $this->f_list;
	}
}

function folder_contents($folder_id){
	$r = new f();

	$r->the_processing_function($folder_id, getFolders());

	$folders = $r->get_r();
	$folders[$folder_id] = '';
	
	$r2 = new f();
	foreach ($folders as $key => $value) {
		$r2->the_processing_function($key, getDocuments());
	}

	return $r2->get_r();

}

print_r(folder_contents($_GET[folder_id]));

?>