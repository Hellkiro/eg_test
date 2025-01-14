<?php require 'header.php'; ?>
<?php include ('server/connect.php'); ?>

<?php

$category_id = 0;

function getGroups($parent) {
    global $link;
    $table_groups = mysqli_query($link, "SELECT id, id_parent, name FROM docker.groups WHERE id_parent = ".$parent);
    if ($table_groups) {
        $groups = array();
        if (mysqli_num_rows($table_groups)) {
            while ($row = mysqli_fetch_assoc($table_groups)) {
                array_push($groups, array($row['id'], $row['id_parent'], $row['name']));
            }
        }
    }
    return $groups;
}

function renderCategories($category_id) {
    
    $categories = getGroups($category_id);
    
    echo '<div class="level">';
    foreach ($categories as $category) {
        echo '<div class="item"><a href="">'.$category[2].'</a></div>';
    }
    echo '</div>';

}

?>

<main>

    <div class="sidebar">
        <div class="category-nav">
            <?php
                renderCategories($category_id);
            ?>
        </div>
    </div>

    <div class="catalog">
        <div class="catalog__top">
            <div class="sort">
                <p>Сортировать:</p>
                <p class="sort__button" sort="price_asc">По цене ↓</p>
                <p class="sort__button" sort="price_desc">По цене ↑</p>
                <p class="sort__button" sort="name_asc">По названию ↓</p>
                <p class="sort__button" sort="name_desc">По названию ↑</p>
            </div>
            <div class="list-count">
                <p>Товаров на странице:</p>
                <select id="input-list-count">
                    <option value="6">6</option>
                    <option value="12">12</option>
                    <option value="18">18</option>
                </select>
            </div>
        </div>
        <div class="catalog__products">
            
        </div>
        <div class="catalog__bottom">
            <div class="pagination">
                
            </div>
        </div>
    </div>

</main>

<?php require 'footer.php' ?>