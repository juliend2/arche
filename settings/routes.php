<?php

if (!isset($_GET['uri'])) $_GET['uri'] = '/';

// Add as many routes as you want below this line :

route('/', array('ThingsController', 'index'));

// Example routes:
// ---------------
// route('/users/', array('UsersController', 'index'));
// route('/users/login', array('UsersController', 'login'));


// if no route matched the request, 404 error:
respond_404(); 
