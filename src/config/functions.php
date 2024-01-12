<?php
    function checkNestedArrayEndpointKey($path, $array) {
        $parts = explode('/', $path);
    
        foreach ($parts as $part) {
            if (!isset($array[$part])) {
                return false;
            }
            $array = $array[$part];
        }
    
        return !is_array($array);
    }
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    function checkDataValue($data) {
        $message['status'] = true; 
        foreach ($data as $key => $value) {
            if (!isset($value[0])) {
                $message[$key]['error'] = "required";
                $message[$key]['status'] = false;
                $message['status'] = false; 
            } elseif ($value[1] != checkDataType($value[0])) {
                $message[$key]['error'] = "Value Type";
                $message[$key]['value'] = $value[0];
                $message[$key]['type'] = $value[1];
                $message[$key]['status'] = false;
                $message['status'] = false;
            }
        }
        return $message;
    }
    
    function checkDataType($data) {
        if (is_int($data)) {
            return 'Integer';
        } elseif (is_string($data)) {
            return 'String';
        } elseif (is_float($data)) {
            return 'Float';
        } elseif (is_bool($data)) {
            return 'Boolean';
        } elseif (is_array($data)) {
            return 'Array';
        } elseif (is_object($data)) {
            return 'Object';
        } elseif(isValidDate($data)) {
            return 'Date';
        } else{
            return 'Unknown Type';
        }
    }
    
    function isValidDate($date, $format = 'Y-m-d') {
        $dateTime = DateTime::createFromFormat($format, $date);
        return var_dump($dateTime && $dateTime->format($format) === $date);
    }
?>