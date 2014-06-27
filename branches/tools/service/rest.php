<?php
$secretKey = '123456789';
header('Content-Type: application/json');
$partner = $_REQUEST['partner'];
$campaign = $_REQUEST['campaign'];
$account_id = $_REQUEST['account_id'];
$transaction = $_REQUEST['transaction'];
$note = $_REQUEST['note'];
$client_ip = $_REQUEST['client_ip'];
$checksum = sha1($partner . $campaign . $account_id . $transaction . $note . $client_ip . $secretKey);

if($checksum != $_REQUEST['checksum']) {
    $response = array(
        'response_code' => 0,
        'response_message' => 'Invalid checksum',
        'transaction' => $transaction,
    );
} else {
    /*
     * To do something with request data
     * ......
     */
    
    //Return result
    $response = array(
        'response_code' => 1,
        'response_message' => 'Success',
        'transaction' => $transaction,
    );
}
$response['checksum'] = sha1($response['response_code'] . $response['response_message'] . $response['transaction'] .$secretKey);
echo json_encode($response);

