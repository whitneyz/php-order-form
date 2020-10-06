<?php
//this line makes PHP behave in a more strict way
declare(strict_types=1);
ini_set("display_errors", "1");
ini_set("display_startup_errors", "1");
error_reporting(E_ALL);

//we are going to use session variables so we need to enable sessions
session_start();

//setcookie(name, value, expire, path, domain, secure, httponly); todo cookies are not setup correct should be linked to the user
$cookie_name = "coffee";
$cookie_value = "cupcake";
setcookie($cookie_name, $cookie_value, time() + (86400 * 365), "/");


if (!isset($_COOKIE[$cookie_name])) {
    "Cookie named '" . $cookie_name . "' is not set!";
} else {
    "Cookie '" . $cookie_name . "' is set!<br>";
    "Value is: " . $_COOKIE[$cookie_name];
}// todo make invisible on page

function whatIsHappening()
{
    echo '<h2>$_GET</h2>';
    var_dump($_GET);
    echo '<h2>$_POST</h2>';
    var_dump($_POST);
    echo '<h2>$_COOKIE</h2>';
    var_dump($_COOKIE);
    echo '<h2>$_SESSION</h2>';
    var_dump($_SESSION);
}
whatIsHappening();

//e-mail validation

// define variables and set to empty values
$email = $street = $streetNumber = $zipCode = $city = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $street = test_input($_POST["street"]);
    $streetNumber = test_input($_POST["streetnumber"]);
    $zipCode = test_input($_POST["zipcode"]);
    $city = test_input($_POST["city"]);
}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data); //todo Sicco will explain why this don't work
    return $data;
}

?>
<form
        method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
</form>
<?php
// define variables and set to empty values
$streetErr = $emailErr = $streetNumberErr = $zipCodeErr = $cityErr = "";
$street = $email = $streetNumber = $zipCode = $city = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["email"])) {
        $emailErr = "email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }// in form-view automatically the email error message what is applicable
    }

    if (empty($_POST["street"])) {
        $streetErr = "street is required";
    } else {
        $street = test_input($_POST["street"]);
    }

    if (empty($_POST["streetnumber"])) {
        $streetNumberErr = "streetnumber is required";
    } else {
        $streetNumber = test_input($_POST["streetnumber"]);
        if (!filter_var($streetNumber, FILTER_VALIDATE_INT)) {
            $streetNumberErr = "Please enter only numbers.";
        }
    }

    if (empty($_POST["zipcode"])) {
        $zipCodeErr = "zipcode is required";
    } else {
        $zipCode = test_input($_POST["zipcode"]);
        if (!filter_var($zipCode, FILTER_VALIDATE_INT)) {
            $zipCodeErr = "Please enter only numbers.";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "city is required";
    } else {
        $city = test_input($_POST["city"]);
    }
}
$ordermessage = "";
if (empty($streetErr && $emailErr && $streetNumberErr && $zipCodeErr && $cityErr)) {
    $ordermessage = "Your order has been sent";
} //todo not working correct fix it with debugger
//todo your products with their price.

if ($_GET["food"]=="1") {
    $products = [
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else {
    $products = [
        ['name' => 'Cola', 'price' => 2],
        ['name' => 'Fanta', 'price' => 2],
        ['name' => 'Sprite', 'price' => 2],
        ['name' => 'Ice-tea', 'price' => 3],
    ];
}
// todo difference between food and drinks

$totalValue = 0;


// todo Set session variables new page?? don't forget session function above page (is it correct?????)
$_SESSION["street"] = "";
$_SESSION["streetnumber"] = "";
$_SESSION["zipcode"] = "";
$_SESSION["city"] = "";
//echo "Session variables are set.";


/* Both GET and POST create an array (e.g. array( key1 => value1, key2 => value2, key3 => value3, ...)). This array
holds key/value pairs,
where keys are the names of the form controls and values are the input data from the user. */


//index for all your logic

require 'form-view.php';
?>
