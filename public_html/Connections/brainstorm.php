<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_brainstorm = "localhost";
$database_brainstorm = "brainstorm";
$username_brainstorm = "brainstorm";
$password_brainstorm = "cerebrito";
$brainstorm = mysql_pconnect($hostname_brainstorm, $username_brainstorm, $password_brainstorm) or trigger_error(mysql_error(),E_USER_ERROR); 
?>