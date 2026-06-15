<?php
require_once 'db.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $qwery1 = "SELECT * FROM user_import";
    $result1 = mysqli_query($link, $qwery1);
    while($row1 = mysqli_fetch_assoc($result1)) {
         $role = $row1['id_role'];
         $fio = $row1['fio_userImp'];
    if($username == $row1['login_userImp'] && $password == $row1['password_userImp'] && $role==2) {
        $_SESSION["fio_userImp"] = $fio;
        header('Location: /manager.php');
        exit();
    } 
    else if ($username == $row1['login_userImp'] && $password == $row1['password_userImp'] && $role==1) {
        $_SESSION["fio_userImp"] = $fio;
        header('Location: /admin.php');
        exit();
    }
    else if ($username == $row1['login_userImp'] && $password == $row1['password_userImp'] && $role==3) {
        $_SESSION["fio_userImp"] = $fio;
        header('Location: /user.php');
        exit();
    }
     else{
   }
   }
  
   echo 'Неверный логин или пароль';
}
else{
    echo 'Заполните все поля';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Авторизация</h1>
    <form action="" method="post">
        <h2>Логин</h2>
        <input type="text" name="username"><br><br>
        
        <h2>Пароль</h2>
        <input type="password" name="password"><br><br>

        <button type="submit">Войти</button>
    </form>
<a href="index.php">На главную</a>

</body>
</html>
