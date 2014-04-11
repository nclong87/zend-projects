<?php
// Mini RC4 Encryption Class

function rc4_encrypt($data,$key) {
    $keys[] = '';
    $box[] = '';
    $cipher = '';

    $key_length = strlen($key);
    $data_length = strlen($data);

    for ($i = 0; $i < 256; $i ++) {
        $keys[$i] = ord($key[$i % $key_length]);
        $box[$i] = $i;
    }
    for ($j = $i = 0; $i < 256; $i ++) {
        $j = ($j + $box[$i] + $keys[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $data_length; $i ++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipher .= chr(ord($data[$i]) ^ $k);
    }
    return urlencode(base64_encode($cipher));
}

$test = 'pluskt01';
$key = '123456';
echo '<pre>';
echo 'Data : '.$test.'<br>';
echo "RC4_Encrypted: ".  rc4_encrypt($test, $key);