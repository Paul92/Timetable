<?php

return array(
    'home' => array(
        'title' => 'Bine ai venit',
        'content' => 'home.php',
        'show' => TRUE
    ),
    'timetable' => array(
        'title' => 'Timetable',
        'content' => 'timetable.php',
        'show' => TRUE
    ),
    'schedule' => array(
        'title' => 'Schedule',
        'content' => 'schedule/schedule_VL.php',
        'show' => TRUE
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
        'show' => TRUE
    )
);
