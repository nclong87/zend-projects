<?php
include 'functions.php';
include ROOT_DIR . '/libs/Zend/Db.php';
include ROOT_DIR . '/libs/Zend/Loader.php';
$action = getParam('action');
echo '<pre>';
echo '$action='.$action;
if($action == 'usecard') {
    $id = getParam('id');
    $sql = 'update thecao set `status` = 2, `update` = now() where `id` = ?';
    $db = getDB();
    $stmt = $db->prepare($sql);
    $stmt->execute(array($id));
    $stmt->closeCursor();
}

echo '<br>';
die('DONE');