<?php
require_once 'db.php';

$id = isset($_GET['id']) ? $_GET['id'] : 0;
$tovar = null;

if($id > 0) {
    $r = mysqli_query($link, "SELECT * FROM `tovar` WHERE `id_tovar` = $id");
    $tovar = mysqli_fetch_assoc($r);
}

if(isset($_POST['save'])) {
    $description = $_POST['description_tovar'];
    $cost = $_POST['cost_tovar'];
    $ed = $_POST['ed_tovar'];
    $count = $_POST['count_tovar'];
    $id_category = $_POST['id_category_tovar'];
    $id_typetovar = $_POST['id_typeTovar_tovar'];
    $id_proizvod = $_POST['id_proizvod_tovar'];
    $id_postav = $_POST['id_postav_tovar'];
    $id_skidka = $_POST['id_skidka_tovar'];

    if($id > 0) {
        mysqli_query($link, "UPDATE `tovar` SET `description_tovar`='$description', `cost_tovar`='$cost', `ed_tovar`='$ed', `count_tovar`='$count', `id_category_tovar`=$id_category, `id-typeTovar_tovar`=$id_typetovar, `id_proizvod_tovar`=$id_proizvod, `id_postav_tovar`=$id_postav, `id-skidka_tovar`=$id_skidka WHERE `id_tovar`=$id");
    } else {
        mysqli_query($link, "INSERT INTO `tovar` (`description_tovar`, `cost_tovar`, `ed_tovar`, `count_tovar`, `id_category_tovar`, `id-typeTovar_tovar`, `id_proizvod_tovar`, `id_postav_tovar`, `id-skidka_tovar`) VALUES ('$description', '$cost', '$ed', '$count', $id_category, $id_typetovar, $id_proizvod, $id_postav, $id_skidka)");
    }

    header('Location: admin.php');
    exit();
}

$categories = mysqli_query($link, "SELECT * FROM `category`");
$types = mysqli_query($link, "SELECT * FROM `typetovar`");
$proizvod = mysqli_query($link, "SELECT * FROM `proizvoditel`");
$postavshik = mysqli_query($link, "SELECT * FROM `postavshik`");
$skidki = mysqli_query($link, "SELECT * FROM `skidka`");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
</head>
<body>

<h1><?php echo $id > 0 ? 'Редактирование товара' : 'Добавление товара'; ?></h1>

<form action="" method="post">

Описание товара:<br>
<input type="text" name="description_tovar" value="<?php echo $tovar['description_tovar'] ?? ''; ?>"><br><br>

Цена:<br>
<input type="text" name="cost_tovar" value="<?php echo $tovar['cost_tovar'] ?? ''; ?>"><br><br>

Единица измерения:<br>
<input type="text" name="ed_tovar" value="<?php echo $tovar['ed_tovar'] ?? ''; ?>"><br><br>

Количество на складе:<br>
<input type="number" name="count_tovar" value="<?php echo $tovar['count_tovar'] ?? ''; ?>"><br><br>

Категория:<br>
<select name="id_category_tovar">
<?php while($c = mysqli_fetch_assoc($categories)) { ?>
<option value="<?php echo $c['id_category']; ?>" <?php if(($tovar['id_category_tovar'] ?? '') == $c['id_category']) echo 'selected'; ?>><?php echo $c['name_category']; ?></option>
<?php } ?>
</select><br><br>

Тип товара:<br>
<select name="id_typeTovar_tovar">
<?php while($t = mysqli_fetch_assoc($types)) { ?>
<option value="<?php echo $t['id_typeTovar']; ?>" <?php if(($tovar['id-typeTovar_tovar'] ?? '') == $t['id_typeTovar']) echo 'selected'; ?>><?php echo $t['name_typeTovar']; ?></option>
<?php } ?>
</select><br><br>

Производитель:<br>
<select name="id_proizvod_tovar">
<?php while($pr = mysqli_fetch_assoc($proizvod)) { ?>
<option value="<?php echo $pr['id_proizvod']; ?>" <?php if(($tovar['id_proizvod_tovar'] ?? '') == $pr['id_proizvod']) echo 'selected'; ?>><?php echo $pr['name_proizvod']; ?></option>
<?php } ?>
</select><br><br>

Поставщик:<br>
<select name="id_postav_tovar">
<?php while($ps = mysqli_fetch_assoc($postavshik)) { ?>
<option value="<?php echo $ps['id_postav']; ?>" <?php if(($tovar['id_postav_tovar'] ?? '') == $ps['id_postav']) echo 'selected'; ?>><?php echo $ps['name_postav']; ?></option>
<?php } ?>
</select><br><br>

Скидка:<br>
<select name="id_skidka_tovar">
<?php while($sk = mysqli_fetch_assoc($skidki)) { ?>
<option value="<?php echo $sk['id_skidka']; ?>" <?php if(($tovar['id-skidka_tovar'] ?? '') == $sk['id_skidka']) echo 'selected'; ?>><?php echo $sk['count_skidka']; ?> %</option>
<?php } ?>
</select><br><br>

<button type="submit" name="save">Сохранить</button>
<a href="admin.php">Отмена</a>

</form>
</body>
</html>
