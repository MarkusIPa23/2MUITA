<?php

function dd($data){
    echo"<pre>";
    var_dump($data);
    echo"</pre>";
    die();
}

function abort($code = 404) {
    http_response_code($code);
    
    if (file_exists("views/{$code}.view.php")) {
        require "views/{$code}.view.php";
    } else {
        echo "Kļūda $code. Lapa netika atrasta.";
    }
    
    die();
}

function authorize($condition) {
    if (!$condition) {
        header("Location: /login");
        exit();
    }
}