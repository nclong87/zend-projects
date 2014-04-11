<!DOCTYPE html>
<?php
include 'functions.php';
include ROOT_DIR . '/libs/Zend/Db.php';
include ROOT_DIR . '/libs/Zend/Loader.php';
$id = getParam('id');
$sql = 'SELECT * FROM thecao where id = ?';
$db = getDB();
$stmt = $db->prepare($sql);
$stmt->execute(array($id));
$row = $stmt->fetch();
?>
<html>
    <head>
        <title>Print</title>
        <meta charset="UTF-8">
        <style>
table {
border-collapse: collapse;
}
td, th {
border: 1px solid black;
}
        </style>
    </head>
    <body>
    <center style="padding-top: 100px">
        <div style="display: block; border: 1px solid gray; padding: 2px; height: 127px; width: 252px; position: relative;">
            <img src="/images/<?php echo $row['mang']?>.jpg" style="border: 1px solid rgb(128, 128, 128); opacity: 0.6;"/>
            <span style="display: block; position: absolute; text-align: center; width: 100%; top: 5px; font-weight: bold; font-size: 17px;"><?php echo $row['mang'].' '.$row['loaithe']?></span>
            <span style="display: block; position: absolute; text-align: center; width: 100%; font-weight: bold; font-family: -moz-fixed; font-size: 28px; top: 35px;"><?php echo $row['mathe']?></span>
            <span style="display: block; position: absolute; width: 100%; font-family: -moz-fixed; text-align: left; padding-left: 53px; color: rgb(85, 85, 85); font-size: 14px; top: 94px;"><?php echo $row['serial']?></span>
            <span style="display: block; position: absolute; width: 100%; font-family: -moz-fixed; text-align: left; color: rgb(85, 85, 85); font-size: 14px; padding-left: 44px; top: 109px;"><?php echo $row['hsd']?></span>
        </div>
    </center>
        
    </body>
</html>