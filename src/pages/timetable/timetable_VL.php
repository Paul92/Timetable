<?php
if (isset($errors)) {
    echo "OK";
    foreach ($errors as $error) {
        echo $error, '</br>';
    }
}

var_dump($data);
