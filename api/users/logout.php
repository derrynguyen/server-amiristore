<?php
header( 'Access-Control-Allow-Origin:*' );
header( 'Content-Type: application/json' );
header( 'Access-Control-Allow-Methods:POST' );

// Start the session
session_start();

// Unset the session variables
session_unset();

// Destroy the session
session_destroy();

// Remove the session ID cookie
setcookie( 'session_id', '', time() - 3600, '/', 'localhost', true, true );