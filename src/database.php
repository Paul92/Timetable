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
    //TODO: think about calling mysqli_connect at every function call. The 
    //database should be the same
    static $dbLink = NULL;
    $dbLink = mysqli_connect(HOST, USER, PASS, DB_NAME);
    if (is_null($dbLink)) {
        exit('Connect error '.mysqli_connect_errno());
    }
    return $dbLink;
}

/**
 * Disconnect from database
 */
function disconnect(){
    mysqli_close(connect());
}
