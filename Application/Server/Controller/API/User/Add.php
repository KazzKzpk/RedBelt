<?php

namespace Application\Server\Controller\API\User
{
    use Application\Server\Component;
    use Application\Server\Model;

    class Add extends \Controller
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
            if (\Connection::getRequestMethod() !== 'post')
                return self::error('INVALID_METHOD', ['message' => 'Only POST method available.']);

            $input = $input->post;

            // Validate inputs
            if ($input->name->isEmpty() === true)
                return self::error('INVALID_NAME');

            if ($input->email->isEmpty() === true || \Email::isValidAddress($input->email) === false)
                return self::error('INVALID_EMAIL');

            $input->phone = $input->phone->getOnlyNumbers();
            if ($input->phone->length() < 10)
                return self::error('INVALID_PHONE');

            if (\Identification\BRA\CPF::isValid($input->cpf) === false)
                return self::error('INVALID_CPF');

            // Format
            $input->cpf     = \Identification\BRA\CPF::getMasked($input->cpf);
            $input->email   = $input->email->toLower();
            $input->phone   = Component\InputMask::maskPhone($input->phone);

            // Verify duplicated
            if (Model\User::getByEmail($input->email) !== null)
                return self::error('EMAIL_ALREADY_IN_USE');
            if (Model\User::getByCPF($input->cpf) !== null)
                return self::error('CPF_ALREADY_IN_USE');

            // Add
            $user = new Model\User();
            $user->name     = $input->name;
            $user->email    = $input->email;
            $user->phone    = $input->phone;
            $user->cpf      = $input->cpf;
            $user->save();

            // Return
            $data = $user->toArr();
            return self::success($data);
        }
    }
}