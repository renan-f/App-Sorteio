<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

/*
estudo
*/

$router->get("/api/users", "UsersController@getAll");
$router->group(['prefix' => "/api/user", 'Middleware' => ['CorsDomain']], function () use ($router) {
    $router->get("/{id}", "UsersController@get");
    $router->post("/login", "UsersController@login");
    $router->post("/", "UsersController@store");
    $router->post("/edit/{id}", "UsersController@update");
    $router->delete("/{id}", "UsersController@destroy");
});

$router->get("/api/awards", "AwardsController@getAll");
$router->get("/api/awards/user/{idUser}", "AwardsController@getAllForUser");
$router->get("/api/awards/sweepstake/user/{idUser}", "AwardsController@getAwardsForUserInSweepstake");
$router->group(["prefix" => "/api/award", 'Middleware' => ['CorsDomain']], function () use ($router) {
    $router->get("/{id}", "AwardsController@get");
    $router->post("/", "AwardsController@store");
    $router->post("/{id}", "AwardsController@update");
    $router->delete("/{id}", "AwardsController@destroy");
});

$router->get("/api/sweepstakes", "SweepstakesController@getAll");
$router->get("/api/sweepstakes/user/{idUser}", "SweepstakesController@getAllForUser");
$router->group(["prefix" => "/api/sweepstake", 'Middleware' => ['CorsDomain']], function () use ($router) {
    $router->get("/{id}", "SweepstakesController@get");
    $router->post("/", "SweepstakesController@store");
    $router->put("/{id}", "SweepstakesController@update");
    $router->delete("/{id}", "SweepstakesController@destroy");
});

$router->post("/api/participant", "ParticipantsController@store");
$router->get("/api/participants/sweepstake/{idSweepstake}", "ParticipantsController@getAllForSweepstake");

$router->post("/api/sweepstake-result", "SweepstakeResultController@store");
$router->get("/api/sweepstake-result/sweepstake/{idSweepstake}", "SweepstakeResultController@getAllForSweepstake");
