<?php

namespace Application\Server\Controller\API\User
{
    use Application\Server\Model;

    class GetAll extends \Controller
    {
        public static function onRequest($input)
        {
            // Check method
            if (\Connection::getRequestMethod() !== 'get')
                return self::error('INVALID_METHOD', ['message' => 'Only GET method available.']);

            $users = Model\User::getAll();
            $users = (($users === null) ? Arr() : $users->toArr(true));

            return self::success(['users' => $users]);
        }
    }
}