<?php
/** @var \Laravel\Lumen\Routing\Router $router */

$router->group(['namespace' => 'v1', 'prefix' => 'v1'], function () use ($router) {
    $router->post('/lead', 'LeadController@store');
    $router->post('/leads/{token}', 'LeadController@search');
    $router->post('/all', 'LeadController@index');
    $router->post('/export', 'LeadController@exportLeads');
    $router->post('/lead/update/{id}', 'LeadController@updateLead');
});
