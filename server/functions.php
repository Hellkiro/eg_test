<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Europe/Moscow"); 

function get_categories($link) {
	//получаем все категории
	$table_groups = mysqli_query($link, "SELECT id, id_parent, name FROM docker.groups");
	if ($table_groups) {
		$groups = array();
		if (mysqli_num_rows($table_groups)) {
			while ($row = mysqli_fetch_assoc($table_groups)) {
				array_push($groups, array($row['id'], $row['id_parent'], $row['name']));
			}
			echo json_encode(array("success" => true,"message" => 'records ok', "data" => $groups));
		} else {echo json_encode(array("success" => false,"message" => 'no records category'));}
	} else {echo json_encode(array("success" => false,"message" => 'sql error category'));}
}

function get_catalog($link, $category, $sort, $limit, $page) {

	$category_sql = "WHERE products.id_group != 0";
	
	if ($category != 0) {
		
		//получаем все категории
		$table_groups = mysqli_query($link, "SELECT id, id_parent FROM docker.groups");
		if ($table_groups) {
			$groups = array();
			if (mysqli_num_rows($table_groups)) {
				while ($row = mysqli_fetch_assoc($table_groups)) {
					array_push($groups, array($row['id'], $row['id_parent']));
				}
			} else {echo json_encode(array("success" => false,"message" => 'no records category'));}
		} else {echo json_encode(array("success" => false,"message" => 'sql error category'));}
		
		//формируем массив вхождений подкатегорий
		$category_in = [];
		array_push($category_in, $category);
		foreach ($groups as $group) {
			if (in_array($group[1], $category_in)) {
				array_push($category_in, $group[0]);
			}
		}

		//делаем строку запроса
		$category_in = implode(",", $category_in);
		$category_sql = "WHERE products.id_group IN (".$category_in.")";
	}

	$sort_sql = "ORDER BY products.id ASC";
	if ($sort != 'default') {
		if ($sort == 'name_asc') $sort_sql = "ORDER BY products.name ASC";
		else if ($sort == 'name_desc') $sort_sql = "ORDER BY products.name DESC";
		else if ($sort == 'price_asc') $sort_sql = "ORDER BY prices.price ASC";
		else if ($sort == 'price_desc') $sort_sql = "ORDER BY prices.price DESC";
		else $sort_sql = "ORDER BY products.id DESC";
	}
	
	$table = mysqli_query($link,
		"SELECT products.id, products.name, prices.price
		FROM products
		JOIN prices ON products.id = prices.id_product
		".$category_sql."
		".$sort_sql."
		LIMIT ".$limit." OFFSET ".($page - 1) * $limit);

	$count_table = mysqli_query($link, "SELECT COUNT(id) FROM products ".$category_sql);
	$count = mysqli_fetch_assoc($count_table);
	$count = $count['COUNT(id)'];
	
	if ($table) {
		$data = array();
		if (mysqli_num_rows($table)) {
			while ($row = mysqli_fetch_assoc($table)) {
				array_push($data, array($row['id'], $row['name'], $row['price']));
			}
			echo json_encode(array("success" => true, "message" => 'records ok', "data" => $data, "count" => $count));
		} else {echo json_encode(array("success" => false,"message" => 'no records'));}
	} else {echo json_encode(array("success" => false,"message" => 'sql error'));}

}




?>