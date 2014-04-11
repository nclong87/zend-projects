<!DOCTYPE html>
<?php
include 'functions.php';
include ROOT_DIR . '/libs/Zend/Db.php';
include ROOT_DIR . '/libs/Zend/Loader.php';
$sql = 'SELECT * FROM thecao where 1 = 1 ';
$params = array();
foreach ($_GET as $key => $value) {
    if(!empty($value)) {
        $value = str_replace('*', '%', $value);
        if (strpos($value,'%') !== false) {
            $sql .= " and $key like :$key ";
        } else {
            $sql .= " and $key = :$key ";
        }
        $params[$key] = $value;
    }
}
$sql.='order by id desc';
$db = getDB();
$stmt = $db->prepare($sql);
$stmt->execute($params);
$rows = $stmt->fetchAll();
$total = count($rows);
?>
<html>
    <head>
        <title>Danh sach the</title>
        <meta charset="UTF-8">
        <script type='text/javascript' src='/js/jquery-latest.js'></script>
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
        <form method="GET" action="">
            <select name="status" id="status">
                <option value="">All</option>
                <option value="1">Chưa sử dụng</option>
                <option value="2">Đã sử dụng</option>
            </select>
            <select name="mang" id="mang">
                <option value="">Tất cả mạng</option>
                <option value="Viettel">Viettel</option>
                <option value="Mobifone">Mobifone</option>
                <option value="Vinafone">Vinafone</option>
                <option value="Vietnam Mobile">Vietnam Mobile</option>
            </select>
            <input type="text" name="mathe" id="mathe" style="width: 150px" placeholder="Mã thẻ"/>
            <br clear="all" style="margin-bottom:10px"/>
            <input type="submit" value="Search"/>
        </form>
        <h4>Tong so the : <?php echo $total?></h4>
        <table >
            <thead>
                <tr>
                    <th>
                        Id
                    </th>
                    <th>
                        Serial
                    </th>
                    <th>
                        Ma The
                    </th>
                    <th>
                        Mang
                    </th>
                    <th>
                        HSD
                    </th>
                    <th>
                        Loai The
                    </th>
                    <th>
                        Ngay import
                    </th>
                    <th>
                        Ngay su dung
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($rows as $row) {
                ?>
                <tr>
                    <td align="center" width="30px"><?php echo $row['id']?></td>
                    <td style="padding: 10px"><?php echo $row['serial']?></td>
                    <td style="padding: 10px"><?php echo $row['mathe']?></td>
                    <td style="padding: 10px"><?php echo $row['mang']?></td>
                    <td style="padding: 10px"><?php echo $row['hsd']?></td>
                    <td style="padding: 10px"><?php echo $row['loaithe']?></td>
                    <td style="padding: 10px"><?php echo $row['import']?></td>
                    <td style="padding: 10px"><?php echo $row['update']?></td>
                    <td align="center" style="padding: 10px"><?php echo $row['status']?></td>
                    <td align="center">
                        <a style="margin-right: 15px;" target="_blank" href="/print.php?id=<?php echo $row['id']?>"><img width="40" src="/images/print_printer.png" alt="print it" title="Print"/></a>
                        <a style="margin-right: 15px;" href="javascript:void()" onclick="useCard(<?php echo $row['id']?>)"><img width="40" src="/images/check_box.png" alt="Đã dùng" title="Check"/></a>
                    </td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </body>
</html>
<script type="text/javascript">
    function useCard(id) {
        if(!confirm("Sử dụng thẻ có id="+id)) {
            return;
        }
        window.open("/actions?action=usecard&id="+id,'_blank')
    }
    $(document).ready(function() {
        <?php
            foreach ($_GET as $key => $value) {
                echo '$("#'.$key.'").val("'.$value.'");';
            }
        ?>
    });
</script>