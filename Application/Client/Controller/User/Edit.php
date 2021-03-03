<?php

namespace Application\Client\Controller\User
{
    use Application\Client\Component;

    class Edit
    {
        protected static $cacheData     = null;
        protected static $inputPhone    = null;

        public static function onRequest($data)
        {
            self::$cacheData = $data;

            $userEdit = \Element::find('[data-button=\'user-add\']');
            if ($userEdit !== null) {
                $userEdit->event->onClick(function($event) {
                    self::onEdit();
                });
            }

            $userRemove = \Element::find('[data-button=\'user-remove\']');
            if ($userRemove !== null) {
                $userRemove->event->onClick(function($event) {
                    self::onRemove();
                });
            }

            self::$inputPhone = \Element::find('[data-input=\'user-phone\']');
            if (self::$inputPhone !== null) {
                self::$inputPhone->event->onInput(function($event) {
                    self::onPhone();
                });
                self::onPhone();
            }
        }

        protected static function onPhone()
        {
            $phone = self::$inputPhone->value;
            $phone = Component\InputMask::maskPhone($phone);
            self::$inputPhone->value = $phone;
        }

        protected static function onEdit()
        {
            $data = Arr();
            $data->name     = \Element::find('[data-input=\'user-name\']')->value;
            $data->phone    = \Element::find('[data-input=\'user-phone\']')->value;

            $request = new \Http\Request('/api/user/' . self::$cacheData->user->userId);
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

                \Swal::fire(['title' => 'Usuário alterado com sucesso.', 'icon' => 'success', 'showConfirmButton' => true]);
                return false;
            });

            return null;
        }

        protected static function onRemove()
        {
            $request = new \Http\Request('/api/user/' . self::$cacheData->user->userId);
            $request->method   = 'delete';
            $request->dataType = 'json';

            Component\Loader::show();

            $request->send(function($data) {
                Component\Loader::hide();

                if ($data->containsKey('error') && $data->error !== null) {
                    self::error($data->error);
                    return false;
                }

                Component\Loader::hide();

                \Swal::fire(['title' => 'Usuário removido com sucesso.', 'icon' => 'success', 'showConfirmButton' => false]);
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

            if ($error === 'INVALID_PHONE')
                \Swal::fire(['title' => 'Telefone vazio ou inválido.', 'icon' => 'error']);
            elseif ($error === 'INVALID_NAME')
                \Swal::fire(['title' => 'Nome vazio.', 'icon' => 'error']);
            else \Swal::fire(['title' => 'Erro interno do servidor. Por favor, tente novamente mais tarde.', 'icon' => 'error']);
            return null;
        }
    }
}

