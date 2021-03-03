<?php

namespace Application\Server\Controller\User
{
    use Application\Server\Model;

    class Edit extends \Controller
    {
        protected static function onInput($type) { return [
            'userId' => int
        ]; }

        public static function onRequest($input)
        {
            $input = $input->get;

            $user = Model\User::getByUserId($input->userId);
            if ($user === null || $user->deleted === true)
                return \Header::redirect('/user');

            return self::success(['user' => $user->toArr()]);
        }

        public static function onRender($response)
        {
            $render = new \Render\Front();
            $render->addViewFromPath('view://User/Edit.html.twig');
            return $render;
        }
    }
}