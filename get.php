<?php

$iterations = 11;
$url = 'http://192.168.100.31:8080/scanlog/all/paging';

// SN
$dataList = ['xxx', 'xxx', 'xxx'];
$errorLog = 'error_log.txt';
$snIndex = 0;

// Loop SN list
foreach ($dataList as $sn) {
    $snIndex++;

    // Output file
    $outputFile = 'hasil_request22_' . $snIndex . '.txt';

    // Loop iterasi
    for ($i = 1; $i <= $iterations; $i++) {
        $postData = http_build_query(['sn' => $sn, 'limit' => '']);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        file_put_contents($outputFile, $response . PHP_EOL, FILE_APPEND);
        //cek respon 
        if (strpos($response, '{"Result":false,"IsSession":false,"message_code":0,"message":"No data"}') !== false) {
            //save respon err log
            file_put_contents($errorLog, 'Kesalahan untuk SN ' . $snIndex . ' - SN: ' . $sn . ' - {"Result":false,"IsSession":false,"message_code":0,"message":"No data"}' . PHP_EOL, FILE_APPEND);
        }
    }
}
?>
