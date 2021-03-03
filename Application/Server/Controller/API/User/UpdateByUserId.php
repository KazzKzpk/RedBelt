<?php

namespace Application\Server\Controller\API\User
{
    use Application\Server\Component;
    use Application\Server\Model;

    class UpdateByUserId extends \Controller
    {
        protected static function onInput($type) { return [
            'name'  => string,
            'email' => string,
            'phone' => string,
            'cpf'   => string,
        ]; }

        public static function onRequest($input)
        {
            // Check method
            $method = \Connection::getRequestMethod();
            if ($method !== 'post' && $method !== 'get' && $method !== 'delete')
                return self::error('INVALID_METHOD', ['message' => 'Only GET/POST/DELETE method available.']);

            $input = $input->post;

            $user = Model\User::getByUserId($input->userId);
            if ($user === null || $user->deleted === true)
                return self::error('INVALID_USER_ID');

            if ($method === 'post')
                return self::onUpdate($input, $user);
            elseif ($method === 'delete')
                return self::onDelete($user);

            return self::success(['user' => $user->toArr()]);
        }

        protected static function onUpdate($input, $user)
        {
            // Validate inputs
            if ($input->name->isEmpty() === true)
                return self::error('INVALID_NAME');

            $input->phone = $input->phone->getOnlyNumbers();
            if ($input->phone->length() < 10)
                return self::error('INVALID_PHONE');

            // Format
            $input->phone = Component\InputMask::maskPhone($input->phone);

            // Update
            $user->name     = $input->name;
            $user->phone    = $input->phone;
            $user->save();

            return self::success(['user' => $user->toArr()]);
        }

        protected static function onDelete($user)
        {
            if ($user->deleted === true)
                return self::error('INVALID_USER_ID');

            // Update
            $user->deleted = true;
            $user->save();

            return self::success(['user' => $user->toArr()]);
        }
    }
}