<?php
    class server_check{


        function checkSSH($host) {
            $port = 22;
            $timeout = 10; 

            $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);
            if ($socket) {
                $res['message'] = "SSH service is up on {$host}:{$port}\n";
                $res['status'] = true;
                fclose($socket);
            } else {
                $res['message'] = "SSH service is down on {$host}:{$port}. Error: $errstr\n";
                $res['status'] = false;
            }
            return $res;
        }
        function checkFTP($url) {
            $parsedUrl = parse_url($url);
            $ftp_server = $parsedUrl['host'] ?? $url; //  עבור שימוש ב URL
            $ftp_port = 21; 
            $timeout = 10; 
        
            $connection = @ftp_connect($ftp_server, $ftp_port, $timeout);
        
            if ($connection) {
                $res['status'] = true;
                $res['message'] = "FTP OK";
                ftp_close($connection); 
            } else {
                $res['message'] = "FTP Is Down";
                $res['status'] = false;
            }
            return $res; 
        }
        function checkFTPS($host) {
            $ftp_server = $host;
            $ftp_port = 990; 
            $timeout = 10; 
            
            $connection = @ftp_ssl_connect($ftp_server, $ftp_port, $timeout);

            if ($connection) {
                $res['status'] = true;
                $res['message'] = "FTP OK";
                ftp_close($connection); 
            } else {
                $res['message'] = "FTP Is Down";
                $res['status'] = false;

            }
            return $res;
        }
        function checkWebserverHTTP($url){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $start_time = microtime(true);
            $response = curl_exec($ch);
            $end_time = microtime(true);
            $latency = $end_time - $start_time;
            $res['status'] = true;
            if($latency > 60){
                $res['status'] = false;
                $res['info']['latency'] = $latency;
            }else{
                $res['info']['latency'] = $latency;
            }

            $message_latency = "latency is" . $latency;


            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            if ($httpCode >= 200 && $httpCode < 300) {
                $message_status_code = "Response is a 2xx success status code, Res code: ".$httpCode." ";
                $res['info']['http_code'] = $httpCode;
            } else {
                $message_status_code = "Response code is not in the 2xx range, Res code: ".$httpCode." ";
                $res['info']['http_code'] = $httpCode;
                $res['status'] = false;
            }


            $res['message'] = "Message latency HTTP code:". $message_latency;
            $res['message'] .= "Info latency code:". $message_status_code;

            curl_close($ch);
            return $res;
        }
    }

?>


