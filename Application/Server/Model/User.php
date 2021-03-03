<?php

namespace Application\Server\Model
{
    use Application\Server\Model;

    /**
     * Class User
     * @package Application\Server\Model
     * @table user
     */
    class User extends \Model
    {
        /**
         * @type int
         * @define isPrimary
         * @define autoIncrement
         * @define cantUpdate
         */
        public $userId;

        /**
         * @type varchar(128)
         * @define isNullable
         */
        public $name;

        /**
         * @type varchar(128)
         * @define isNullable
         */
        public $email;

        /**
         * @type varchar(15)
         * @define isNullable
         */
        public $phone;

        /**
         * @type varchar(14)
         * @define isNullable
         */
        public $cpf;

        /**
         * @type bool
         * @define isEnumerated
         */
        public $deleted;

        /**
         * @type \DateTimeEx
         * @define isNullable
         */
        public $date;

        /**
         * @type \DateTimeEx
         * @define isNullable
         */
        public $dateUpdate;

        public static function getByUserId(int $userId)
        {
            if ($userId <= 0)
                return null;

            $result = self::selectAll() ->
                whereEquals ('userId', $userId) ->
                limit(1)->
                result();

            return ($result === null)
                ? null : $result[0];
        }

        public static function getByCPF(string $cpf)
        {
            if ($cpf->isEmpty())
                return null;

            $cpf = \Identification\BRA\CPF::getMasked($cpf);

            $result = self::selectAll() ->
                whereEquals ('cpf', $cpf) ->
                whereEquals ('deleted', false) ->
                limit(1)->
                result();

            return ($result === null)
                ? null : $result[0];
        }

        public static function getByEmail(string $email)
        {
            if ($email->isEmpty())
                return null;

            $result = self::selectAll() ->
                whereEquals ('email', $email) ->
                whereEquals ('deleted', false) ->
                limit(1)->
                result();

            return ($result === null)
                ? null : $result[0];
        }

        public static function getAll(int $limit = \intEx::LIMIT)
        {
            if ($limit <= 0) $limit = 1;

            $result = self::selectAll() ->
                whereEquals ('deleted', 'false')->
                limit($limit)->
                result();

            return $result;
        }

        public static function getCount()
        {
            return self::selectAll()->
                whereEquals('deleted', false)->
                getCount();
        }

        protected function onSave($model)
        {
            $data = null;

            if (!$model->containsField('date') || $model->date === null) {
                $model->date = null;

                if ($model->containsField('userId') && $model->userId !== null && $model->userId > 0) {
                    $data           = self::getByUserId($model->userId);
                    $model->date    = $data->date;
                }

                if ($model->date === null)
                    $model->date = \DateTimeEx::now();
            }

            $model->dateUpdate = \DateTimeEx::now();
            return $model;
        }
    }
}