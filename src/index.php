<?php

const CORE_FUNCTIONS_NOT_FOUND = "ERROR: functions.php not found\n";
const CORE_PAGES_NOT_FOUND = "ERROR: pages.php not found\n";

if(!file_exists('functions.php') && !is_readable('functions.php')){
    exit(CORE_FUNCTIONS_NOT_FOUND);
}

require_once 'functions.php';

if(!file_exists('pages.php') && !is_readable('pages.php')){
    exit(CORE_PAGES_NOT_FOUND);
}

$pages=require_once 'pages.php';

$page='home';

if(isset($_GET['show'])){
    if(array_key_exists($_GET['show'], $pages))
        $page=$_GET['show'];
    else
        $page='notfound';
}

$menu=build_menu_from_pages($pages, $page);

$page_and_menu=array(
    'menu' => $menu, 
    'content' => $page
);

render('layout.php', $page_and_menu);
