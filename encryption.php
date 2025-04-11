<?php
function alpha_digit() {
    $alpha = range('a', 'z');
   
    $digit = "";
    for ($i = 0; $i < 10; $i++) {
        $digit .= $i;
    }
    for ($j = 0; $j < strlen($digit); $j++) {
        array_push($alpha, $digit[$j]);
    }
    return $alpha;
}

function vc_tac() {
    $alpha_digit = alpha_digit();
    $results = [];
    for ($i = 0; $i < count($alpha_digit); $i++) {
        $a = array_slice($alpha_digit, $i, count($alpha_digit));
        $b = array_slice($alpha_digit, 0, $i);
        $merge = array_merge($a, $b);
        $results[] = $merge;
    }
    return $results;
}

function repeat_key($key, $message) {
    $result = "";
    for ($i = 0; $i < strlen($message); $i++) {
        $result .= $key[$i % strlen($key)];
    }
    return $result;
}

function encrypt($code, $key) {
    $res = "";
    $alpha_digit = alpha_digit();
    $vc_table = vc_tac();
    $repeated_key = repeat_key($key, $code);
    for ($i = 0; $i < strlen($code); $i++) {
        $col = array_search($code[$i], $alpha_digit);
        $row = array_search($repeated_key[$i], $alpha_digit);
        $char = $vc_table[$row][$col];
        $res .= $char;
    }
    return $res;
}

function decrypt($encrypted_code, $key) {
    $res = "";
    $alpha_digit = alpha_digit();
    $vc_table = vc_tac();
    $repeated_key = repeat_key($key, $encrypted_code);
    for ($i = 0; $i < strlen($encrypted_code); $i++) {
        $row_index = array_search($repeated_key[$i], $alpha_digit);
        $row_alpha_digit = $vc_table[$row_index];
        $ori_index = array_search($encrypted_code[$i], $row_alpha_digit);
        $ori_char = $alpha_digit[$ori_index];
        $res .= $ori_char;
    }
    return $res;
}





?>

