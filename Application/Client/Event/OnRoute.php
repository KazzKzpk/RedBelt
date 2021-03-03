<?php

namespace Application\Client\Event
{
    class OnRoute
    {
        public static function onRoute($route)
        {
            $router = new \Router();

            $router->add('/user/add',                 'Application/Client/Controller/User/Add');
            $router->add('/user/{{ userId }}/edit',   'Application/Client/Controller/User/Edit');

            return $router;
        }
    }
}