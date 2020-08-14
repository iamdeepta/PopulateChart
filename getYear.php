<?php
header('Content-Type: application/json');

	 $link = new \PDO(   'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4', //'mysql:host=localhost;dbname=canvasjs_db;charset=utf8mb4',
							'root', //'root',
							'', //'',
							array(
								\PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
								\PDO::ATTR_PERSISTENT => false
							)
						);
						
	$handle = $link->prepare("SELECT DISTINCT(YEAR(x)) as year FROM datapoints order by x");
    $handle->execute(); 
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
	$unique_years = array();
	foreach($result as $row){
        array_push($unique_years, $row->year);
    }
	
	$link = null;
echo json_encode($unique_years, JSON_NUMERIC_CHECK);