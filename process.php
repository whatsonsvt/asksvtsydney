<?php
try {
    if(isset($_POST['submit'])){
        $query = $_POST['message'];
        $sessionid = $_POST['sessionid'];
        $postData = array('query' => array($query), 'lang' => 'en', 'sessionId' => $sessionid);
        $jsonData = json_encode($postData);
        $v = date('Ymd');
        $ch = curl_init('https://api.api.ai/v1/query?v='.$v);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer dc1319d7431d4989a52c43eccae1234a'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }
}
catch (Exception $e) {
    $speech = $e->getMessage();
    $fulfillment = new stdClass();
    $fulfillment->speech = $speech;
    $result = new stdClass();
    $result->fulfillment = $fulfillment;
    $response = new stdClass();
    $response->result = $result;
    echo json_encode($response);
}
