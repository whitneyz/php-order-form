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
$email = $street = $streetNumber = $zipCode = $city = $expressDelivery = "";
$totalValue = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["email"]);
    $street = test_input($_POST["street"]);
    $streetNumber = test_input($_POST["streetnumber"]);
    $zipCode = test_input($_POST["zipcode"]);
    $city = test_input($_POST["city"]);
    $expressDelivery = isset($_POST["express_delivery"]);//todo expressdelivery should be set even if you don't tick the box
    //$expressDelivery = test_input($_POST["express_delivery"]); moet niet door test_input maar waarom niet (omdat het alleen een checkbox is)
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
$street = $email = $streetNumber = $zipCode = $city = "";//should express_Delivery also be defined here???


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
        if (!preg_match("/^[a-zA-Z-' ]*$/", $street)) {
            $streetErr = "Only letters and white space allowed";
        } else {
            $_SESSION["street"] = $street;
        }
    }
    if (empty($_POST["streetnumber"])) {
        $streetNumberErr = "streetnumber is required";
    } else {
        $streetNumber = test_input($_POST["streetnumber"]);
        if (!filter_var($streetNumber, FILTER_VALIDATE_INT)) {
            $streetNumberErr = "Only numbers allowed";
        }
    }

    if (empty($_POST["zipcode"])) {
        $zipCodeErr = "zipcode is required";
    } else {
        $zipCode = test_input($_POST["zipcode"]);
        if (!filter_var($zipCode, FILTER_VALIDATE_INT)) {
            $zipCodeErr = "Only numbers allowed";
        }
    }

    if (empty($_POST["city"])) {
        $cityErr = "city is required";
    } else {
        $city = test_input($_POST["city"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $city)) {
            $cityErr = "Only letters and white space allowed";
        }
    }
}

/*if (empty($streetErr && $emailErr && $streetNumberErr && $zipCodeErr && $cityErr)) && {
$ordermessage = "Your order has been sent and will be delivered within 2 hours";
    //todo sicco zegt hier eens te controleren, en de post in een variable steken en controleren eerst
} else {
    $ordermessage = "Your order has been sent and will be delivered within 45 minutes";
    //todo deze else is prima maar kan mss vanboven komen als er niets fout is EN spoed levering
}*/

/*$ordermessage = "";
if (empty($streetErr && $emailErr && $streetNumberErr && $zipCodeErr && $cityErr)) {
$ordermessage = "Your order has been sent";*/
// todo it works but not so well don't know anymore what the problem is
//todo not working correct fix it with debugger


if (empty($expressDelivery) && empty($streetErr) && empty($emailErr) && empty($streetNumberErr) && empty($zipCodeErr) && empty($cityErr)) {
    $ordermessage = "Your order has been sent and will be delivered within 2 hours";
} else if ($streetErr or $emailErr or $streetNumberErr or $zipCodeErr or $cityErr) {
    $ordermessage = "Please fill in the order form correct";
} else {
    $ordermessage = "Your order has been sent and will be delivered within 45 min";
}

if ($_GET == []) {
    $products = [//lentgh of this array needed for calculation
        ['name' => 'Club Ham', 'price' => 3.20],
        ['name' => 'Club Cheese', 'price' => 3],
        ['name' => 'Club Cheese & Ham', 'price' => 4],
        ['name' => 'Club Chicken', 'price' => 4],
        ['name' => 'Club Salmon', 'price' => 5]
    ];
} else if ($_GET["food"] == "1") {
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


if (isset($_POST["products"])) {// zien of de array products bestaat
    $food = $_POST["products"];
    $c = count($products);
    $totalValue = 0;

    for ($i = 0; $i < $c; $i++) {
        if (isset($food[$i])) { //check of de producten in array set zijn
            $totalValue = $totalValue + $products[$i]["price"];
            echo "you have selected a " . $products[$i]["name"];
        }
    }
    //price should be printed outside
} else {
    echo "please choose your sandwich or drink";
}
/* "products[<?php echo $i ?>]"*/


$_SESSION["streetnumber"] = "";
$_SESSION["zipcode"] = "";
$_SESSION["city"] = "";
$_SESSION["express_delivery"] = "";
//echo "Session variables are set.";


/* Both GET and POST create an array (e.g. array( key1 => value1, key2 => value2, key3 => value3, ...)). This array
holds key/value pairs,
where keys are the names of the form controls and values are the input data from the user. */


//index for all your logic

require 'form-view.php';
?>
