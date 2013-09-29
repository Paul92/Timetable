<?php
/**
 * Controller
 */

/**
 * Controller constants:
 */
const CORE_FUNCTIONS_NOT_FOUND = "ERROR: functions.php not found\n";
const CORE_PAGES_NOT_FOUND = "ERROR: pages.php not found\n";
const DATABASE_MODULE_NOT_FOUND = "ERROR: database.php not found\n";
const MODEL_NOT_FOUND = "ERROR: model not found\n";

const DATABASE_MODULE = 'database.php';

if (!file_exists('functions.php') || !is_readable('functions.php')) {
    exit(CORE_FUNCTIONS_NOT_FOUND);
}
require_once 'functions.php';

if (!file_exists('pages.php') || !is_readable('pages.php')) {
    exit(CORE_PAGES_NOT_FOUND);
}
$pages=require_once 'pages.php';

if (!file_exists('database.php') || !is_readable('database.php')) {
    exit(DATABASE_MODULE_NOT_FOUND);
}

/**
 * Page to be shown. Default is home
 */
$page = 'home';

if (isset($_GET['show'])) {
    if (array_key_exists($_GET['show'], $pages)) {
        $page = $_GET['show'];
    } else {
        $page = 'notfound';
    }
}

if (!file_exists($pages[$page]['model']) || !is_readable($pages[$page]['model'])){
    exit(MODEL_NOT_FOUND);
}
$data = require_once $pages[$page]['model'];

/**
 * $menu holds the menu shown on page
 */
$menu = build_menu_from_pages($pages, $page);

/**
 * This array is used to pass variables to page modules
 */
$vars = array(
    'menu'    => $menu, 
    'content' => $pages[$page]['content'],
    'title'   => $pages[$page]['title'],
    'data'    => $data
);

render('layout.php', $vars);
