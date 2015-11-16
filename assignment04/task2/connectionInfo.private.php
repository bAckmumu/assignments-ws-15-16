<?php


/*
 * to prevent errors (and if you can't use other solutions)
 * it makes sense to put your credentials in a dedicated,
 * separated file that you ensure has correct syntax and ins interpretable.
 * if errors occur in other files then, that is not that big of a deal
 * as long as no sensitive information leaks to the user.
 *
 *
 * Here, we store the info about the host, user, password.
 *
 * Include the file like so:
 * include_once('connectionInfo');
 */


$host = "localhost"; // if you use a local database this is 'localhost' or '127.0.0.1'
$user = "test"; // try not to use the root user.
$password = "geheim"; // try to create a strong password.
$db = "assignment04"; // optional. if you only have one database, you can specify it here.