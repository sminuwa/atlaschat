<?php
	if(!isset($dbh)){
		$dbh = null;
	}

	if(!function_exists("try_db_connect")) {
		function try_db_connect($persistent = false){
			global $dbh;
		
			if ($dbh != null) {
				return $dbh;
			}
		
			$db_host		= 'localhost';
			$db_user		= 'root';
			$db_pass		= '';
			$db_database	= 'chatapp';
	
			$pdo_hlp = 'pdo/class/class.pdohelper.php';
			include_once($pdo_hlp);
			
			$pdo_wrp =  'pdo/class/class.pdowrapper.php';	
			include_once($pdo_wrp);
			
			$dbConfig = array("host"=>$db_host, "dbname"=>$db_database, "username"=>$db_user, "password"=>$db_pass);
	
			$db = new PdoWrapper($dbConfig);
			$helper = new PDOHelper();
			
			// set error log mode true to show error on screen or false to log in log file
			$db->setErrorLog(false);
	
			return $db;
		}
	}
?>
