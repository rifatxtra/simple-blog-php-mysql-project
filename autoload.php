<?php
spl_autoload_register(function ($classname) {
    $prefix = 'LH\\';
    $name=substr($classname,strlen($prefix));
    $file=str_replace('\\','/',$name).'.php';

    if(file_exists($file)){
        require $file;
    }
});
