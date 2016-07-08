<?php

header("Content-Type:text/html;charset=UTF8");

include 'config.php';
include 'functions/functions.php';

db(HOST, USER, PASS, DB);

$result = get_cat();
echo "<div style='width:450px;padding:10px;border:1px solid #747777'>";
view_cat($result);
echo "</div>";