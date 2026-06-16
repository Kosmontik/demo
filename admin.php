<?php
require_once 'db.php';

$name = $_SESSION["fio_userImp"];

if(isset($_GET["delete"])) {
    mysqli_query($link, "DELETE FROM `tovar` WHERE `id_tovar` = ".$_GET["delete"]);
    header("Location: admin.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$postav = isset($_GET['postav']) ? $_GET['postav'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

$query = "SELECT `tovar`.`id_tovar`, `tovar`.`photo_tovar`, `category`.`name_category`, `typetovar`.`name_typeTovar`, `tovar`.`description_tovar`,
`proizvoditel`.`name_proizvod`, `postavshik`.`name_postav`, `tovar`.`cost_tovar`, `tovar`.`ed_tovar`, `tovar`.`count_tovar`, `skidka`.`count_skidka`
FROM `tovar`
LEFT JOIN `skidka` ON `tovar`.`id-skidka_tovar` = `skidka`.`id_skidka`
LEFT JOIN `typetovar` ON `tovar`.`id-typeTovar_tovar` = `typetovar`.`id_typeTovar`
LEFT JOIN `postavshik` ON `tovar`.`id_postav_tovar` = `postavshik`.`id_postav`
LEFT JOIN `proizvoditel` ON `tovar`.`id_proizvod_tovar` = `proizvoditel`.`id_proizvod`
LEFT JOIN `category` ON `tovar`.`id_category_tovar` = `category`.`id_category`";

$result = mysqli_query($link, $query);

$tovary = [];
while($row = mysqli_fetch_assoc($result)) {
    $tovary[] = $row;
}

if($postav != '') {
    $tovary = array_filter($tovary, function($row) use ($postav) {
        return $row['name_postav'] == $postav;
    });
}

if($search != '') {
    $tovary = array_filter($tovary, function($row) use ($search) {
        $text = $row['name_category'].' '.$row['name_typeTovar'].' '.$row['description_tovar'].' '.$row['name_proizvod'].' '.$row['name_postav'].' '.$row['ed_tovar'];
        return mb_stripos($text, $search) !== false;
    });
}

if($sort == 'asc') usort($tovary, function($a, $b) { return $a['count_tovar'] - $b['count_tovar']; });
if($sort == 'desc') usort($tovary, function($a, $b) { return $b['count_tovar'] - $a['count_tovar']; });

$result_postav = mysqli_query($link, "SELECT `name_postav` FROM `postavshik`");
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
<h1>Пользователь <?php echo $name; ?></h1>
<a href="auth.php">Авторизация блет</a>
</header>

<form action="" method="get">
<input type="text" name="search" value="<?php echo $search; ?>" placeholder="Поиск...">

<select name="postav">
<option value="">Все поставщики</option>
<?php while($p = mysqli_fetch_assoc($result_postav)) { ?>
<option value="<?php echo $p['name_postav']; ?>" <?php if($postav == $p['name_postav']) echo 'selected'; ?>><?php echo $p['name_postav']; ?></option>
<?php } ?>
</select>

<input type="hidden" name="sort" value="<?php echo $sort; ?>">
<button type="submit">Найти</button>
</form>

<a href="?search=<?php echo $search; ?>&postav=<?php echo $postav; ?>&sort=<?php echo $sort == 'asc' ? 'desc' : 'asc'; ?>">Сортировка по количеству <?php if($sort == 'asc') echo '↑'; elseif($sort == 'desc') echo '↓'; ?></a>

<br><br>
<a href="tovar_form.php">Добавить товар</a>
<br><br>

<?php foreach($tovary as $row) {
$image = $row['photo_tovar'] == null ? 'picture.png' : $row['photo_tovar'];
?>
<section>
<div class="main">
<div class="left">
<img src="img/<?php echo $image?>" alt="">
</div>
<div class="center">
<h2><?php echo $row['name_category']. "|". $row['name_typeTovar']; ?></h2>
<p>Описание товара: <?php echo $row['description_tovar'] ?></p>
<p>Производитель: <?php echo $row['name_proizvod'] ?></p>
<p>Поставщик: <?php echo $row['name_postav'] ?></p>
<p>Цена: <?php echo $row['cost_tovar'] ?></p>
<p>Единица измерения: <?php echo $row['ed_tovar'] ?></p>
<p>Количество на складе: <?php echo $row['count_tovar'] ?></p>
</div>
<div class="right">
<h2>Скидка <?php echo $row['count_skidka'] ?> %</h2>
<a href="tovar_form.php?id=<?php echo $row['id_tovar']; ?>">Редактировать</a>
<a href="?delete=<?php echo $row['id_tovar']; ?>&search=<?php echo $search; ?>&postav=<?php echo $postav; ?>&sort=<?php echo $sort; ?>">Удалить</a>
</div>
</div>
</section>
<?php } ?>

</body>
</html>
