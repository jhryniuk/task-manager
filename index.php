<?php

require_once 'app/bootstrap.php';

Router::handle($_SERVER["REQUEST_URI"]);
