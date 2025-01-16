<?php require 'header.php'; ?>
<?php include ('server/connect.php'); ?>

<main>

    <div class="sidebar">
        <div class="category-nav">
            <?php
                //Получаем подготовленный массив с данными
                $cat  = getCat(); 
                
                //Создаем древовидное меню
                $tree = getTree($cat);
                
                //Получаем HTML разметку
                $cat_menu = showCat($tree);
                
                //Выводим на экран меню
                echo '<ul>'. $cat_menu .'</ul>';
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