<?php

namespace Application\Server\Component
{
    class InputMask
    {
        public static function maskPhone($phone)
        {
            $phone = $phone->getOnlyNumbers();

            if ($phone->length() === 11) {
                $_phone = ('(' . $phone->subString(0, 2) . ') ') .
                    $phone->subString(2, 5) . '-' .
                    $phone->subString(7);
                $phone = $_phone;
            }
            elseif ($phone->length() === 10) {
                $_phone = ('(' . $phone->subString(0, 2) . ') ') .
                    $phone->subString(2, 4) . '-' .
                    $phone->subString(6);
                $phone = $_phone;
            }
            else return $phone;

            return $phone;
        }
    }
}

