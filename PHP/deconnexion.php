<?php
session_start();

require 'classes.php';
$db = new BDD();

if (isset ($_SESSION['user_id'])) {
    $adminSite = new AdminSite($db);
    $adminSite->updateStatus($_SESSION['user_id'], "inactive");
}
session_regenerate_id(true);
session_destroy();
header("Location: connexion.php");
exit();
?>