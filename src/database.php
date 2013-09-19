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
// TODO: unused constants
const HOST = 'localhost';
const USER = 'mysql';
const PASS = '123456';
const DB_NAME = 'timetable';

/**
 * Connect to database
 * 
 * @param str $host database host
 * @param str $user database user
 * @param str $dbName database name
 * 
 * @return mysqli DB
 */
function connect($host, $user, $pass, $dbName){
    static $DB = null; // TODO: should be named $dbLink
    // TODO: check that function parameters are the expected type
    $DB = mysqli_connect($host, $user, $pass, $dbName);
    if (is_null($DB)) {
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
