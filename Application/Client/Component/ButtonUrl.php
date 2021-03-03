<?php

namespace Application\Client\Component
{
    class ButtonUrl
    {
        protected static $isInitialized = false;

        public static function onInitialize($data)
        {
            if (self::$isInitialized === true)
                return null;
            self::$isInitialized = true;

            self::hook();
        }

        public static function hook()
        {
            $buttons = \Elements::find('button[data-url]');
            if ($buttons !== null) {
                foreach ($buttons->elements as $button) {
                    $button->event->onClick(function ($event) {
                        \Header::redirect($event->target->get('data-url'));
                    });
                }
            }
        }
    }
}

