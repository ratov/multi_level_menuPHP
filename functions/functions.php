<?php

function db($host, $user, $pass, $database)
{
    //подключение к БД
    $db = mysql_connect($host, $user, $pass);

    if(!$db) {
        exit(mysql_error());
    }

    //Выбираем БД для работы
    if(!mysql_select_db($database, $db)) {
        exit(mysql_error());
    }

    //Определяем кодировку
    mysql_query("SET NAMES UTF8");
}


//С использованием mysqli
/*function db($host, $user, $pass, $database)
{
    //подключение к БД
    $db = mysqli_connect($host, $user, $pass);

    if(!$db) {
        exit(mysqli_error());
    }

    //Выбираем БД для работы
    if(!mysqli_select_db($db, $database)) {
        exit(mysqli_error());
    }

    //Определяем кодировку
    mysqli_query($db, "SET NAMES UTF8");
}*/



//Выбераем все поля из таблицы categories
function get_cat() {
    $sql = "SELECT id, title, parent_id FROM categories";
    //Выполняем данный запрос и сохраняем результат в переменню $result
    $result = mysql_query($sql);
    if(!$result) {
        return NULL;
    }

    $arr_cat = array();
    if(mysql_num_rows($result) != 0) {
        for($i = 0; $i < mysql_num_rows($result); $i++) {
            $row = mysql_fetch_array($result, MYSQLI_ASSOC);
            if(empty($arr_cat[$row['parent_id']])) {
                $arr_cat[$row['parent_id']] = array();
            }
            $arr_cat[$row['parent_id']][] = $row;
        }
    }
    return $arr_cat;
}


//Функция которая выводит многоуровненвое меняю на экран
function view_cat($arr, $parent_id = 0)
{
    //Описываем условия выхода из рекурсии
    if(empty($arr[$parent_id])) {
        return;
    }

    echo "<ul>";
    for($i = 0; $i < count($arr[$parent_id]); $i++) {
        echo "<li><a href='?category_id=" . $arr[$parent_id][$i]['id'] . "&parent_id=". $parent_id . "'>" . $arr[$parent_id][$i]['title'] . "</a>";

        view_cat($arr, $arr[$parent_id][$i]['id']);
        echo "</li>";
    }
    echo "</ul>";
}