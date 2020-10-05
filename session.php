<?php
// Start the session todo(2x session page?
session_start();
?>

<?php
// todo Set session variables new page?? don't forget session function above page
$_SESSION["favcolor"] = "green";
$_SESSION["favanimal"] = "cat";
echo "Session variables are set.";
?>