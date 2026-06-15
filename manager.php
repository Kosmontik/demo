<?php
require_once 'db.php';

$name=$_SESSION["fio_userImp"];
$query ="SELECT `tovar`.`photo_tovar`, `category`.`name_category`, `typetovar`.`name_typeTovar`, `tovar`.`description_tovar`,
 `proizvoditel`.`name_proizvod`, `postavshik`.`name_postav`, `tovar`.`cost_tovar`, `tovar`.`ed_tovar`, `tovar`.`count_tovar`, `skidka`.`count_skidka`
FROM `skidka`
    LEFT JOIN `tovar` ON `tovar`.`id-skidka_tovar` = `skidka`.`id_skidka`
    LEFT JOIN `typetovar` ON `tovar`.`id-typeTovar_tovar` = `typetovar`.`id_typeTovar`
    LEFT JOIN `postavshik` ON `tovar`.`id_postav_tovar` = `postavshik`.`id_postav`
    LEFT JOIN `proizvoditel` ON `tovar`.`id_proizvod_tovar` = `proizvoditel`.`id_proizvod`
    LEFT JOIN `category` ON `tovar`.`id_category_tovar` = `category`.`id_category`
";
$result = mysqli_query($link, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        text-decoration: none;
    }
    section{
        border: 1px solid gray;
        margin-bottom: 20px;
        display: flex;
        padding: 10px
    }
    .main{
        display: flex;
        justify-content: space-between;
        width: 100%;
        text-align: center;
    }
    .left, .right, .center{ 
        width: 100%;
        border: 1px solid black;
    }
</style>
<body>
    <header>
        <h1>Пользователь <?php
    echo $name;
    ?></h1>
        <a href="auth.php">Авторизация блет</a>
    </header>
    <?php
while($row = mysqli_fetch_assoc($result)) {
$image = $row['photo_tovar'] == null ? 'picture.png' : $row['photo_tovar'] ;
?>
<section>
    <div class="main">
    <div class="left">
        <img src="img/<?php echo $image?>"  alt="">
    </div>

    <div class="center">
        <h2><?php 
        echo $row['name_category']. "|". $row['name_typeTovar']; ?></h2> 
        <p> Описание товара: <?php echo $row['description_tovar']  ?></p>
        <p>Производитель: <?php echo $row['name_proizvod']  ?></p>
        <p>Поставщик: <?php echo $row['name_postav']  ?></p>
        <p>Цена: <?php echo $row['cost_tovar']  ?></p>
        <p>Единица измерения: <?php echo $row['ed_tovar']  ?></p>
        <p>Количество на складе: <?php echo $row['count_tovar']  ?></p>
    </div>
    <div class="right">
        <h2>Скидка <?php echo $row['count_skidka']  ?> %</h2>
    </div>
</div>
</section>

<?php } ?>
</body>
</html>
<?php
while($row = mysqli_fetch_assoc($result)) {
?>


<?php } ?>
