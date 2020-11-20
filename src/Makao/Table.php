<?php


namespace Makao;


use Makao\Collection\CardCollection;
use Makao\Exception\TooManyPlayersAtTheTableException;

class Table
{
    const MAX_PLAYERS = 4;

    private $players = [];

    /** @var CardCollection */
    private $cardDeck;

    /** @var CardCollection */
    private $playedCards;

    /**
     * Table constructor.
     * @param CardCollection $cardDeck
     */
    public function __construct(CardCollection $cardDeck = null)
    {
        $this->cardDeck = $cardDeck ?? new CardCollection();
        $this->playedCards = new CardCollection();
    }


    public function countPlayers() : int
    {
        return count($this->players);
    }

    public function addPlayer(Player $player) : void
    {
        if ($this->countPlayers() == self::MAX_PLAYERS) {
            throw new TooManyPlayersAtTheTableException(self::MAX_PLAYERS);
        }
        $this->players[] = $player;
    }

    public function getPlayedCards()
    {
        return $this->playedCards;
    }

    public function getCardDeck() : CardCollection
    {
        return $this->cardDeck;
    }
}