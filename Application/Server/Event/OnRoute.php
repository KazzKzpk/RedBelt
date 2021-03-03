<?php

namespace Application\Server\Event
{
    class OnRoute
    {
        public static function onRoute($route)
        {
            $router = new \Router();

            $router->add('/',                         'Application/Server/Controller/Index');
            $router->add('/user',                     'Application/Server/Controller/User');
            $router->add('/user/add',                 'Application/Server/Controller/User/Add');
            $router->add('/user/{{ userId }}/edit',   'Application/Server/Controller/User/Edit');

            $router->add('/api/user/add',             'Application/Server/Controller/API/User/Add');
            $router->add('/api/user/{{ userId }}',    'Application/Server/Controller/API/User/UpdateByUserId');
            $router->add('/api/user',                 'Application/Server/Controller/API/User/GetAll');

            return $router;
        }
    }
}