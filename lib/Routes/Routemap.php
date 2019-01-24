<?php

namespace X5\Routes;

class Routemap
{
    public static function registerAuthenticatedRoutes(\Slim\App $app)
    {
        $app->get('/list/{id}/show', Lists\GetX5List::class);
        $app->get('/x5lists/{range_id}', Lists\GetX5Lists::class);
        $app->post('/list/add', Lists\AddX5List::class);
        $app->patch('/list/{id}/alter', Lists\AlterX5List::class);
        $app->get('/list/{id}/remove', Lists\RemoveX5List::class);

        $app->get('/item/{id}/show', Items\GetX5Item::class);
        $app->get('/item/add', Items\AddX5Item::class);
        $app->get('/item/{id}/alter', Items\AlterX5Item::class);
        $app->get('/item/{id}/remove', Items\RemoveX5Item::class);
    }
}
