<?php
// $username = 'admin';
// $password = 'admin';
// if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
// ($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
//    header('HTTP/1.1 401 Unauthorized');
//    header('WWW-Authenticate: Basic realm="Admin Realm"');
//    exit('<p>Sorry, you must enter a valid user name and password.</p>');
// }
?>

<?php
$username = 'admin';
$password = 'admin';
if (($_SERVER['PHP_AUTH_USER'] != $username) || ($_SERVER['PHP_AUTH_PW'] != $password)) {
   header('HTTP/1.1 401 Unauthorized');
   header('WWW-Authenticate: Basic realm="Admin Realm"');
   exit('<p>Sorry, you must enter a valid user name and password.</p>');
}
?>
