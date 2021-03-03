<?php

namespace Application\Server\Controller
{
    use Application\Server\Controller;

    class User extends \Controller
    {
        public static function onRequest($input)
        {
            return self::success(['users' => Controller\API\User\GetAll::execute()->users]);
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://User.html.twig');
            return $render;
        }
    }
}