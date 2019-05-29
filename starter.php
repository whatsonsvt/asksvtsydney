<?php
try {
    // create curl resource
    $ch = curl_init();
    // set url
    curl_setopt($ch, CURLOPT_URL, "https://api.api.ai/v1/query?v=20150910&e=WELCOME&lang=en&sessionId=" . $sessionID);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer 6965131deda64cf1a74076db916458a8'));
    //return the transfer as a string
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string
    $output = curl_exec($ch);
    // close curl resource to free up system resources
    curl_close($ch);
}catch (Exception $e) {
    $speech = $e->getMessage();
    $fulfillment = new stdClass();
    $fulfillment->speech = $speech;
    $result = new stdClass();
    $result->fulfillment = $fulfillment;
    $response = new stdClass();
    $response->result = $result;
    echo json_encode($response);
}
?>

<div id="dom-target" style="display: none;">
    <?php

        echo htmlspecialchars($output); /* You have to escape because the result will not be valid HTML otherwise. */
    ?>
</div>
