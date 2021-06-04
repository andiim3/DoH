<?php

$upstreamdnsserver = "udp://127.0.0.1";
$upstreamdnsserverport = "53";

if (isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] == 'application/dns-message')
{
        $request = file_get_contents("php://input");
        $s = fsockopen($upstreamdnsserver, $upstreamdnsserverport, $errno, $errstr);
        if ($s)
        {
                header("Content-Type: application/dns-message");
                fwrite($s, $request);
                echo fread($s, 4096);
                fclose($s);
        }else{
                echo "Error processing your request: $request";
        }
}
else if (isset($_GET['dns']))
{
        $request = base64_decode(str_replace(array('-', '_'), array('+', '/'), $_GET['dns']));
        
        $s = fsockopen($upstreamdnsserver, $upstreamdnsserverport, $errno, $errstr);
        if ($s)
        {
                header("Content-Type: application/dns-message");        
                fwrite($s, $request);
                echo fread($s, 4096);
                fclose($s);
        }else{
                echo "Error processing your request: $_GET[dns]";
        }
}else {
        echo "Nothing to see here.."; // put any message you like. For example, how to use this script/server in any device.
}
