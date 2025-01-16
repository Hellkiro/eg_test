<?php if(isset($_GET['id'])): ?>
<?php require 'header.php'; ?>
<?php include ('server/connect.php'); ?>
<?php 

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    date_default_timezone_set("Europe/Moscow"); 
    
    $id = $_GET['id'];

    function getProduct($id) {
        global $link;
        $table = mysqli_query($link, 
            "SELECT products.`name`, products.`id_group`, prices.price
            FROM products
            JOIN prices ON products.id = prices.id_product
            WHERE products.id = ".$id);
        if ($table) {
            $row = mysqli_fetch_assoc($table);
        } else {
            echo 'DB error';
        }
        return $row;
    }

?>

<main>
    <div class="breadcrumbs">
    <?php
        //Получаем подготовленный массив с данными
        $cat  = getCat(); 
    
        //Получаем массив с крошками
        $arr_brc = breadcrumb($cat, getProduct($id)['id_group']);

        //Получаем строку с крошками
        $brc = getBrc($arr_brc);

        //Выводим хлебные крошки
        echo $brc;
    ?>
    </div>
    <h1><?php echo getProduct($id)['name'] ?></h1>
    <h2><?php echo getProduct($id)['price'] ?></h2>
</main>

<?php require 'footer.php' ?>
<?php else: ?>
id error
<?php endif; ?>