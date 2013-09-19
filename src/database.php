<?php
/**
 * This is the database module. It handels all database operations.
 */

/**
 * Constants:
 *
 * HOST - database host
 * USER - database user
 * PASS - database password
 * DB_NAME - database name
 */
const    HOST = 'localhost';
const    USER = 'mysql';
const    PASS = '123456';
const DB_NAME = 'timetable';

/**
 * Connect to database
 *
 * @return mysqli DB
 */
function connect(){
    static $DB;
    $DB = mysqli_connect('localhost', 'mysql', '123456', 'timetable');
    if (!$DB) {
        exit('Connect error '.mysqli_connect_errno());
    }
    return $DB;
}

/**
 * Disconnect from database
 */
function disconnect(){
    mysqli_close(connect());
}
