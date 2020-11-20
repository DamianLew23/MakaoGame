<?php


namespace Makao\Exception;

use Makao\Card;
use Throwable;

class CardDuplicationException extends \Exception
{
    public function __construct(Card $card, $code = 0, Throwable $previous = null)
    {
        $message = "Valid card get the same cards: " . $card->getValue() . " " . $card->getColor();

        parent::__construct($message, $code, $previous);
    }
}