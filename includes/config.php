<?php

if($_SERVER['HTTP_HOST'] == "localhost") {
    define("MYSQL_SERVER", "localhost");
    define("MYSQL_USER", "reboul");
    define("MYSQL_PASS", "");
    define("MYSQL_BASE", "projectweb");
    define("PASSWORD_SALT", "J584gfh4564g&415.1451");
}
else if($_SERVER['HTTP_HOST'] == "serveurdetest.dev") {


}
else if($_SERVER['HTTP_HOST'] == "ppe_project.com") {
    define("MYSQL_SERVER", "45.254.21.4");
    define("MYSQL_USER", "php");
    define("MYSQL_PASS", "DF52D:FFG332é&4RT43FD");
    define("MYSQL_BASE", "ppe_project");
}