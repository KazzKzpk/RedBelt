<?php

namespace Application\Client\Component
{
    class InputMask
    {
        public static function maskPhone($phone)
        {
            $phone = $phone->getOnlyNumbers();

            if ($phone->length > 11)
                $phone = $phone->subString(0, 11);

            if ($phone->length === 0)
                return '';

            if ($phone->length === 1 || $phone->length === 2) {
                $phone = ('(' . $phone);
            }
            elseif ($phone->length === 11) {
                $_phone = ('(' . $phone->subString(0, 2) . ') ') .
                    $phone->subString(2, 5) . '-' .
                    $phone->subString(7);
                $phone = $_phone;
            }
            elseif ($phone->length === 10) {
                $_phone = ('(' . $phone->subString(0, 2) . ') ') .
                    $phone->subString(2, 4) . '-' .
                    $phone->subString(6);
                $phone = $_phone;
            }
            else
            {
                $_phone = ('(' . $phone->subString(0, 2) . ') ');
                if ($phone->length > 6)
                { $_phone .= $phone->subString(2, 4) . '-' . $phone->subString(6); }
                else { $_phone .= ($phone->subString(2)); }
                $phone = $_phone;
            }

            return $phone;
        }

        public static function maskCPF($cpf)
        {
            $cpf = $cpf->getOnlyNumbers();

            if ($cpf->length > 11)
                $cpf = $cpf->subString(0, 11);

            if ($cpf->length === 0)
                return '';

            if ($cpf->length > 9) {
                $_cpf = $cpf->subString(0, 3) . '.' .
                    $cpf->subString(3, 3) . '.' .
                    $cpf->subString(6, 3) . '-' .
                    $cpf->subString(9, 2);
                $cpf = $_cpf;
            }
            elseif ($cpf->length > 6) {
                $_cpf = $cpf->subString(0, 3) . '.' .
                    $cpf->subString(3, 3) . '.' .
                    $cpf->subString(6, 3);
                $cpf = $_cpf;
            }
            elseif ($cpf->length > 3) {
                $_cpf = $cpf->subString(0, 3) . '.' .
                    $cpf->subString(3, 3);
                $cpf = $_cpf;
            }

            return $cpf;
        }
    }
}

