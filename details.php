<?php
function curlPostRequest($endpoint, $data)
{
    $token = 'eyJhbGciOiJIUzUxMiJ9.eyJhdWQiOiJwcmF0aWsiLCJzdWIiOiJwcmF0aWsiLCJpc3MiOiJLYW5pbmlTb2Z0VGVjaCIsImV4cCI6MTU4NzkzMDQ2NSwiaWF0IjoxNTg3OTEyNDY1fQ.jJ8yhAh6P5fTIrvo2e1h2ZjsrSxd7kIvWXu-wV_L8ScHicZyCnb1Wr8pLKWtbMdGh90gyW0lsTUHB1akPyztGw';
    $ch = curl_init($endpoint);
    $post = json_encode($data);
    $authorization = "Authorization: Bearer " . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function curlGetRequest($endpoint)
{
    $token = 'eyJhbGciOiJIUzUxMiJ9.eyJhdWQiOiJwcmF0aWsiLCJzdWIiOiJwcmF0aWsiLCJpc3MiOiJLYW5pbmlTb2Z0VGVjaCIsImV4cCI6MTU4NzkzMDQ2NSwiaWF0IjoxNTg3OTEyNDY1fQ.jJ8yhAh6P5fTIrvo2e1h2ZjsrSxd7kIvWXu-wV_L8ScHicZyCnb1Wr8pLKWtbMdGh90gyW0lsTUHB1akPyztGw';
    $ch = curl_init();
    $authorization = "Authorization: Bearer " . $token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
    curl_setopt($ch, CURLOPT_URL, $endpoint);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result);
}

if (isset($_POST['type']) && $_POST['type'] == 'add') {
    $array = array("name" => $_POST['countryname'], "latitude" => $_POST['latitude'], "longitude" => $_POST['longitude']);
    $endpoint = 'http://52.66.253.230:8080/LeadManager/countryCreate';
    $resp = curlPostRequest($endpoint, $array);
    echo json_encode($resp);
}

if (isset($_POST['type']) && $_POST['type'] == 'edit') {
    $array = array("name" => $_POST['countryname'], "latitude" => $_POST['latitude'], "longitude" => $_POST['longitude'], "rowId" => $_POST['rowId']);
    $endpoint = 'http://52.66.253.230:8080/LeadManager/countryEdit';
    $resp = curlPostRequest($endpoint, $array);
    echo json_encode($resp);
}

if (isset($_GET['type']) && $_GET['type'] == 'show') {
    $endpoint = 'http://52.66.253.230:8080/LeadManager/getCountry';
    return curlGetRequest($endpoint);
}

if (isset($_POST['type']) && $_POST['type'] == 'delete' && isset($_POST['rowId']) && !empty($_POST['rowId'])) {
    $endpoint = 'http://52.66.253.230:8080/LeadManager/countryDelete?rowIDs=' . $_POST['rowId'];
    return curlGetRequest($endpoint);
}

if (isset($_POST['type']) && $_POST['type'] == 'deletemultiple' && isset($_POST['rowIds']) && !empty($_POST['rowIds'])) {
    $rows = json_decode($_POST['rowIds'], TRUE);
    foreach ($rows as $key => $val) {
        $endpoint = 'http://52.66.253.230:8080/LeadManager/countryDelete?rowIDs=' . $val;
        $resp = curlGetRequest($endpoint);
    }
    return $resp;
}
