<?php if(isset($_GET['id'])): ?>
<?php require 'header.php'; ?>
<?php include ('server/connect.php'); ?>
<?php 

    //ini_set('display_errors', 1);
    //ini_set('display_startup_errors', 1);
    //error_reporting(E_ALL);
    
    date_default_timezone_set("Europe/Moscow"); 
    
    $id = $_GET['id'];

    $table = mysqli_query($link, 
        "SELECT products.`name`, prices.price
        FROM products
        JOIN prices ON products.id = prices.id_product
        WHERE products.id = ".$id);
    if ($table) {
        $row = mysqli_fetch_assoc($table);
    } else {
        echo 'DB error';
    }

?>

<main>
    <h1><?php echo $row['name'] ?></h1>
    <h2><?php echo $row['price'] ?></h2>
</main>

<?php require 'footer.php' ?>
<?php else: ?>
id error
<?php endif; ?>