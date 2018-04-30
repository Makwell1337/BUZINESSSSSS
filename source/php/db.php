<?php

require "libs/rb.php";
R::setup( 'mysql:host=localhost;dbname=hardbet',
    'root', '' );

session_start();