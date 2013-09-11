<?php

function render($template, $vars=NULL){

    if($vars){
        foreach($vars as $key => $val){
            $$key=$val;
        }
        include $template;
    }

}

function build_menu_from_pages($pages, $currentPage){
    $r='<ul>';
    foreach($pages as $pagename => $metadata){
        if($currentPage!=$pagename)
            $r.='<li><a href="?show='.$pagename.'">'.$metadata['title'].'</a></li>';
    }
    return $r.'</ul>';
}
