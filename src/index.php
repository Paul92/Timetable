<?php

const CORE_FUNCTIONS_NOT_FOUND = "ERROR: functions.php not found\n";
const CORE_PAGES_NOT_FOUND = "ERROR: pages.php not found\n";

if(!file_exists('functions.php') && !is_readable('functions.php')){
    echo CORE_FUNCTIONS_NOT_FOUND;
}else{
    require_once 'functions.php';

    if(!file_exists('pages.php') && !is_readable('pages.php')){
        echo CORE_PAGES_NOT_FOUND;
    }else{
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
    }
}
