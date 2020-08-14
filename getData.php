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
	$handle = $link->prepare("SELECT * FROM datapoints where YEAR(x) = :year order by x");
	$handle->bindParam(":year",$_GET["year"], PDO::PARAM_INT);
    $handle->execute(); 
    $result = $handle->fetchAll(\PDO::FETCH_OBJ);
	$data_points = array();
	foreach($result as $row){
		// x column is in timestamp, convert unixtimestamp(seconds) to javascript timestamp(milliseconds) by multipying the x value by 1000 Please refer https://stackoverflow.com/a/15593812 for more information
        array_push($data_points, array("x"=> strtotime($row->x)*1000, "y"=> $row->y));
    }
	$link = null;

echo json_encode($data_points, JSON_NUMERIC_CHECK);