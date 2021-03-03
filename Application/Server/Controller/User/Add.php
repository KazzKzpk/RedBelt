<?php

namespace Application\Server\Controller\User
{
    class Add extends \Controller
    {
        public static function onRequest($input)
        {
            return self::success();
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://User/Edit.html.twig');
            return $render;
        }
    }
}