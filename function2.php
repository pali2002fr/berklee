<?php

	function getDB(){
		include('database.php');
		return new PDO('mysql:host=' . LOCALHOST . ';dbname=' . DBNAME . ';charset=utf8', USER, PWD);
	}

	//Get all folders
	function getFolders() {
		$_return = array();
		$db = getDB();
   		$stmt = $db->query("SELECT i.id, i.parent_id, i.name FROM folders f INNER JOIN items i ON f.id = i.id");
   		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//Get all documents
	function getDocuments() {
		$db = getDB();
   		$stmt = $db->query("SELECT i.id, i.parent_id, i.name FROM documents d INNER JOIN items i ON i.id = d.id");
   		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	//Get documents and folders by folder Id
	function folder_contents($folder_id){
		foreach (getFolders() as $key => $valueFol) {
			if($valueFol['parent_id'] == $folder_id){
				foreach (getDocuments() as $key => $valueDoc) {
					if($valueDoc['parent_id'] == $valueFol['id'] || $valueDoc['parent_id'] == $folder_id){
						$list[$valueDoc['id']] = $valueDoc['name'];
					}
				}
			}
		}
		return $list;
	}

	//Displays result
	echo "<pre>";
	print_r(folder_contents($_GET[folder_id]));
	echo "</pre>";
?>