<?php

return array(
    'home' => array(
        'title' => 'Bine ai venit',
        'content' => 'home/home_VL.php',
        'show' => TRUE,
        'model' => 'pages/home/home_BL.php'
    ),
    'timetable' => array(
        'title' => 'Timetable',
        'content' => 'timetable/timetable_VL.php',
        'show' => TRUE,
        'model' => 'pages/timetable/timetable_BL.php'
    ),
    'schedule' => array(
        'title' => 'Schedule',
        'content' => 'schedule/schedule_VL.php',
        'show' => TRUE,
        'model' => 'pages/schedule/schedule_BL.php'
    ),
    'courses' => array(
        'title' => 'Courses',
        'content' => 'courses/courses_VL.php',
        'show' => TRUE,
        'model' => 'pages/courses/courses_BL.php'
    ),
    'notfound' => array(
        'title' => 'Not Found',
        'content' => 'notfound.php',
        'show' => FALSE
    ),
    'addSubject' => array(
        'title' => 'Add Subject',
        'content' => 'courses/addSubject_VL.php',
        'show' => FALSE,
        'model' => 'pages/courses/addSubject_BL.php'
    ),
    'subjectSettings' => array(
        'title' => 'Subject Settings',
        'content' => 'courses/subjectSettings_VL.php',
        'show' => FALSE,
        'model' => 'pages/courses/subjectSettings_BL.php'
    ),
    'teachers' => array(
        'title' => 'Teachers',
        'content' => 'teachers/teachers_VL.php',
        'show' => TRUE,
        'model' => 'pages/teachers/teachers_BL.php'
    )
);
