<?php


namespace Makao\Collection;


use Makao\Card;
use Makao\Exception\CardNotFoundException;
use Makao\Exception\MethodNotAllowedException;

class CardCollection implements \Countable, \Iterator, \ArrayAccess
{
    const FIRST_CARD_INDEX = 0;

    private $cards = [];
    private $position = self::FIRST_CARD_INDEX;

    public function __construct(array $cards = [])
    {
        $this->cards = $cards;
    }


    public function count() : int
    {
        return count($this->cards);
    }

    public function add($card): self
    {
        $this->cards[] = $card;
        return $this;
    }

    public function pickCard() : Card
    {
        if (empty($this->cards)) {
            throw new CardNotFoundException('You can not pick card from empty CardCollection');
        }

        $pickedCard = $this->offsetGet(self::FIRST_CARD_INDEX);
        $this->offsetUnset(self::FIRST_CARD_INDEX);
        $this->cards = array_values($this->cards);

        return $pickedCard;
    }


    public function current() : ?Card
    {
        return $this->cards[$this->position];
    }

    public function next() : void
    {
        ++$this->position;
    }

    public function key() : int
    {
        return $this->position;
    }

    public function valid() : bool
    {
        return isset($this->cards[$this->position]);
    }

    public function rewind(): void
    {
        $this->position = self::FIRST_CARD_INDEX;
    }

    public function offsetExists($offset) : bool
    {
        return isset($this->cards[$offset]);
    }

    public function offsetGet($offset) : Card
    {
        return $this->cards[$offset];
    }

    public function offsetSet($offset, $value) : void
    {
        throw new MethodNotAllowedException('You can not add card to collection as array. Use addCard() method!');
    }

    public function offsetUnset($offset) : void
    {
        unset($this->cards[$offset]);
    }

    public function toArray() : array
    {
        return $this->cards;
    }
}