<?php

namespace Application\Client\Controller\User
{
    use Application\Client\Component;

    class Add
    {
        protected static $inputPhone = null;

        public static function onRequest($data)
        {
            $prospectAdd = \Element::find('[data-button=\'user-add\']');
            if ($prospectAdd !== null) {
                $prospectAdd->event->onClick(function($event) {
                    self::onAdd();
                });
            }

            self::$inputPhone = \Element::find('[data-input=\'user-phone\']');
            if (self::$inputPhone !== null) {
                self::$inputPhone->event->onInput(function($event) {
                    self::onPhone();
                });
            }

            self::$inputCPF = \Element::find('[data-input=\'user-cpf\']');
            if (self::$inputCPF !== null) {
                self::$inputCPF->event->onInput(function($event) {
                    self::onCPF();
                });
            }
        }

        protected static function onPhone()
        {
            $phone = self::$inputPhone->value;
            $phone = Component\InputMask::maskPhone($phone);
            self::$inputPhone->value = $phone;
        }

        protected static function onCPF()
        {
            $cpf = self::$inputCPF->value;
            $cpf = Component\InputMask::maskCPF($cpf);
            self::$inputCPF->value = $cpf;
        }

        protected static function onAdd()
        {
            $data = Arr();
            $data->name     = \Element::find('[data-input=\'user-name\']')->value;
            $data->email    = \Element::find('[data-input=\'user-email\']')->value;
            $data->phone    = \Element::find('[data-input=\'user-phone\']')->value;
            $data->cpf      = \Element::find('[data-input=\'user-cpf\']')->value;

            $request = new \Http\Request('/api/user/add');
            $request->method   = 'post';
            $request->dataType = 'json';

            $request->data = $data;

            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                Component\Loader::hide();

                \Swal::fire(['title' => 'Usuário adicionado com sucesso.', 'icon' => 'success', 'showConfirmButton' => false]);
                \FunctionEx::delay(function() {
                    \Header::redirect('/user/');
                }, 1000);

                return false;
            });

            return null;
        }

        protected static function error($error)
        {
            Component\Loader::hide();

            if ($error === 'EMAIL_ALREADY_IN_USE')
                \Swal::fire(['title' => 'Email já foi cadastrado.', 'icon' => 'error']);
            elseif ($error === 'CPF_ALREADY_IN_USE')
                \Swal::fire(['title' => 'CPF já foi cadastrado.', 'icon' => 'error']);
            elseif ($error === 'INVALID_CPF')
                \Swal::fire(['title' => 'CPF vazio ou inválido.', 'icon' => 'error']);
            elseif ($error === 'INVALID_PHONE')
                \Swal::fire(['title' => 'Telefone vazio ou inválido.', 'icon' => 'error']);
            elseif ($error === 'INVALID_EMAIL')
                \Swal::fire(['title' => 'Email vazio ou inválido.', 'icon' => 'error']);
            elseif ($error === 'INVALID_NAME')
                \Swal::fire(['title' => 'Nome vazio.', 'icon' => 'error']);
            else \Swal::fire(['title' => 'Erro interno do servidor. Por favor, tente novamente mais tarde.', 'icon' => 'error']);
            return null;
        }
    }
}

