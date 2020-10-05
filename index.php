<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

//setcookie(name, value, expire, path, domain, secure, httponly);
$cookie_name = "coffee";
$cookie_value = "cupcake";
setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/");


if (!isset($_COOKIE[$cookie_name])) {
    echo "Cookie named '" . $cookie_name . "' is set!";
} else {
    echo "Cookie '" . $cookie_name . "' is set!<br>";
    echo "Value is: " . $_COOKIE[$cookie_name];
}


function whatIsHappening() {
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}

//your products with their price.
$products = [
    ['name' => 'Club Ham', 'price' => 3.20],
    ['name' => 'Club Cheese', 'price' => 3],
    ['name' => 'Club Cheese & Ham', 'price' => 4],
    ['name' => 'Club Chicken', 'price' => 4],
    ['name' => 'Club Salmon', 'price' => 5]
];


$products = [
    ['name' => 'Cola', 'price' => 2],
    ['name' => 'Fanta', 'price' => 2],
    ['name' => 'Sprite', 'price' => 2],
    ['name' => 'Ice-tea', 'price' => 3],
];

$totalValue = 0;

/*<?php
// todo Set session variables new page?? don't forget session function above page
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>*/

/* Both GET and POST create an array (e.g. array( key1 => value1, key2 => value2, key3 => value3, ...)). This array holds key/value pairs,
where keys are the names of the form controls and values are the input data from the user.*/

require 'form-view.php';







//index for all your logic