<?php
// https://www.php.net/manual/ru/book.mysqli.php
function connect(
    //openserver phpMyAdmin
    $host = 'localhost',
    $user = 'root',
    $pass = '',
    $dbname = 'travelbase'
) {
    $mysql = mysqli_connect($host, $user, $pass) or die('connection error');
    mysqli_select_db($mysql, $dbname) or die('DB open error');
    mysqli_query($mysql, "set names 'utf8'");
    return $mysql;
}

function register($name, $pass, $email)
{
    $name = trim(htmlspecialchars($name));
    $pass = trim(htmlspecialchars($pass));
    $email = trim(htmlspecialchars($email));
    if ($name == "" || $pass == "" || $email == "") {
        echo "<h3/><span style='color:red;'>Fill All Required Fields!</span><h3/>";
        return false;
    }
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Values Length Must Be Between 3 And 30!</span><h3/>";
        return false;
    }
    $ins = 'INSERT INTO users (login,pass,email,roleid) VALUES ("' . $name . '","' . md5($pass) . '","' . $email . '",2)';
    $mysql = connect();
    mysqli_query($mysql, $ins);
    $err = mysqli_errno($mysql);
    if ($err) {
        if ($err == 1062)
            echo "<h3/><span style='color:red;'>This Login Is Already Taken!</span><h3/>";
        else
            echo "<h3/><span style='color:red;'>Error code:" . $err . "!</span><h3/>";
        return false;
    }

    return true;
}

function login($name, $pass)
{
    $name = trim(htmlspecialchars($name));
    $pass = trim(htmlspecialchars($pass));
    if ($name == "" || $pass == "") {
        echo "<h3/><span style='color:red;'>Fill All Required Fields!</span><h3/>";
        return false;
    }
    if (strlen($name) < 3 || strlen($name) > 30 || strlen($pass) < 3 || strlen($pass) > 30) {
        echo "<h3/><span style='color:red;'>Values Length Must Be Between 3 And 30!</span><h3/>";
        return false;
    }
    $mysql = connect();
    $sel = 'SELECT * FROM users WHERE login="' . $name . '"	AND pass="' . md5($pass) . '"';
    $res = mysqli_query($mysql, $sel);
    if ($row = mysqli_fetch_array($res, MYSQLI_NUM)) {
        $_SESSION['ruser'] = $name;
        if ($row[5] == 1) {
            $_SESSION['radmin'] = $name;
        }
        return true;
    } else {
        echo "<h3/><span style='color:red;'>No Such User!</span><h3/>";
        return false;
    }

}