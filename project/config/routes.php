<?php

use \Core\Route;

return [
    new Route('/', 'TaskController', 'index', 'GET'),
    new Route('/tasks', 'TaskController', 'store', 'POST'),
    new Route('/tasks/:taskId/', 'TaskController', 'show', 'GET'),
    new Route('/tasks/:taskId/update', 'TaskController', 'update', 'POST'),
    new Route('/tasks/:taskId/delete', 'TaskController', 'delete', 'POST'),

    new Route('/login', 'AuthController', 'index', 'GET'),
    new Route('/login', 'AuthController', 'login', 'POST'),
    new Route('/logout', 'AuthController', 'logout', 'POST'),
];
	
