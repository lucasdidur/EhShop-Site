<?
    include "loader.php";

    $stmt = $db->prepare('SELECT name, description FROM `ea_packages` WHERE `id_package` = ? LIMIT 1');
    $stmt->execute(array( $_REQUEST['id']));

    $package = $stmt->fetch(PDO::FETCH_ASSOC);

?>


<h4 class="modal-title"><? echo $package['name'] ?></h4>

<? echo $package['description'] ?>

