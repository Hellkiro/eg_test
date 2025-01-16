<?php include ('server/connect.php'); ?>
<?php 

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    date_default_timezone_set("Europe/Moscow"); 

    //Получаем массив нашего меню из БД в виде массива
    function getCat(){
        global $link;
        $sql = 'SELECT * FROM `groups`';
        $res = $link->query($sql);

        //Создаем масив где ключ массива является ID меню
        $cat = array();
        while($row = $res->fetch_assoc()){
            $cat[$row['id']] = $row;
        }
        return $cat;
    }

    //Функция построения дерева из массива от Tommy Lacroix
    function getTree($dataset) {
        $tree = array();

        foreach ($dataset as $id => &$node) {    
            //Если нет вложений
            if ($node['id_parent'] == 0){
                $tree[$id] = &$node;
            }else{ 
                //Если есть потомки то перебераем массив
                $dataset[$node['id_parent']]['childs'][$id] = &$node;
            }
        }
        //print_r($tree);
        return $tree;
    }

    //Шаблон для вывода меню в виде дерева
    function tplMenu($category){
        $menu = '<li>
            <a href="?id='. $category['id'] .'" title="'. $category['name'] .'">'.
            $category['name'].'</a>';
            
            if(isset($category['childs'])){
                $menu .= '<ul>'. showCat($category['childs']) .'</ul>';
            }
        $menu .= '</li>';
        
        return $menu;
    }

    /**
    * Рекурсивно считываем наш шаблон
    **/
    function showCat($data, $str = null){
        $string = '';
        $str = $str;
        foreach($data as $item){
            $string .= tplMenu($item, $str);
        }
        return $string;
    }

    /**
     * @param $cat array
     * @param $id int
     * @return array
     * Получаем массив для хлебных крошек
     */
    function breadcrumb($cat, $id){
        //Проверяем что ID это число
        if(!intval($id)) return false;

        //Создаем пустой массив
        $brc = array();

        //Перебираем полученый массив с меню
        for($i = 0; $i < count($cat); $i++){
            //Проверяем что мы не нашли родителя и не массив пуст
            if($id != 0 and !empty($cat[$id])){
                //Ищим родителя
                $brc[$cat[$id]['id']] = $cat[$id]['name'];
                $id = $cat[$id]['id_parent'];
            }
            //Останавливаем цикл
            else break;
        }
        //Возвращаем перевернутый массив с сохранением ключей
        return array_reverse($brc, true);
    }

    /**
     * @param $data array
     * @return string
     * Выводим хлебные крошки
     */
    function getBrc($data){
        //Проверяем что массив не пуст
        if(empty($data)){
            return false;
        }else {
            $brc = $data;
            $brc_menu = '';
            //Перебераем массив для построения хлебных крошек
            foreach ($brc as $id => $title) {
                $brc_menu .= '<a href="/?category=' . $id . '">' . $title . '</a> / ';
            }

            //Обрезаем последний слэш
            $brc_menu = rtrim($brc_menu, ' / ');

            //удаляем ссылку на последний элемент в крошках
            return preg_replace('#(.+)?<a.+>(.+)</a>$#', '$1$2', $brc_menu);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet/less" type="text/css" href="/styles/style.less" />    
    <script src="/scripts/less.min.js" type="text/javascript"></script>         
    <script type="module" src="/scripts/main.js"></script>
    <title>Test</title>
</head>
<body>

<div class="page">

<header>
    
</header>
