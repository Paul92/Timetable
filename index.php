<?php

require_once 'functions.php';
$pages=require_once 'pages.php';

if(isset($_GET['show'])){
    if(array_key_exists($_GET['show'], $pages))
        $page=$_GET['show'];
    else
        $page='notfound';
}else{
    $page='home';
}

$menu=build_menu_from_pages($pages, $page);

$page_and_menu=array(
    'menu' => $menu, 
    'content' => $page
);

render('layout.php', $page_and_menu);
