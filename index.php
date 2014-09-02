<?php

	function getDB(){
		require_once('database.php');
		return new PDO('mysql:host=' . LOCALHOST . ';dbname=' . DBNAME . ';charset=utf8', USER, PWD);
	}

	//Get all folders
	function getFolders() {
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
		$list = array();
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

	if(isset($_GET["folder_id"])  || !empty($_GET["folder_id"])){
		$result = folder_contents($_GET[folder_id]);
		if (count($result) > 0){
			echo "<pre>";
			print_r($result);
			echo "</pre>";
		} else {
			echo 'Empty folder !';
		}
	} else {
		echo 'Folder ID is missing !';
	}
	
?>