<?php

define('SERVER_NAME', 'http://'. $_SERVER['SERVER_NAME']);

const SLASH = '\\';

const CONNECTION = array(
    // required
    'database_type' => 'mysql',
    'database_name' => 'areses_beta',
    'server'        => 'localhost',
    'username'      => 'root',
    'password'      => '',

    // [optional]
    'charset' => 'utf8',

    // [optional] Medoo will execute those commands after connected to the database for initialization
    'command' => [
    'SET SQL_MODE=ANSI_QUOTES'
    ]
  );