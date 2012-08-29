<?php

if (!isset($_GET['uri'])) $_GET['uri'] = '/';

route('/', array('ThingsController', 'index'));

respond_404();
