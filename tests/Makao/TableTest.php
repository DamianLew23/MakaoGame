<?php


namespace Test\Makao;


use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\TooManyPlayersAtTheTableException;
use Makao\Player;
use Makao\Table;
use PHPUnit\Framework\TestCase;

class TableTest extends TestCase
{
    /** @var Table  */
    private $tableUnderTest;

    public function setUp()
    {
        $this->tableUnderTest = new Table();
    }

    public function testShouldCreateEmptyTable() {
        // Given
        $expected = 0;

        // When
        $actual = $this->tableUnderTest->countPlayers();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testShouldAddOnePlayerToTable() {
        // Given
        $expected = 1;
        $player = new Player('Andy');

        // When
        $this->tableUnderTest->addPlayer($player);
        $actual = $this->tableUnderTest->countPlayers();

        // Then
        $this->assertSame($expected, $actual);
    }
    public function testShouldReturnCountWhenIAddManyPlayers() {
        // Given
        $expected = 2;

        // When
        $this->tableUnderTest->addPlayer(new Player('Andy'));
        $this->tableUnderTest->addPlayer(new Player('Tom'));
        $actual = $this->tableUnderTest->countPlayers();

        // Then
        $this->assertSame($expected, $actual);
    }

    public function testShouldThrowTooManyPlayersAtTheTableExceptionWhenITryAddMoreThenFourPlayers()
    {
        // Expect
        $this->expectException(TooManyPlayersAtTheTableException::class);
        $this->expectExceptionMessage('Max capacity is 4 players');

        // When
        $this->tableUnderTest->addPlayer(new Player('Andy'));
        $this->tableUnderTest->addPlayer(new Player('Tom'));
        $this->tableUnderTest->addPlayer(new Player('Max'));
        $this->tableUnderTest->addPlayer(new Player('John'));
        $this->tableUnderTest->addPlayer(new Player('Michael'));
    }

    public function testShouldReturnEmptyCardCollectionForPlayedCard() {
        // When
        $actual = $this->tableUnderTest->getPlayedCards();
        // Then
        $this->assertInstanceOf(CardCollection::class, $actual);
        $this->assertCount(0, $actual);
    }

    public function testShouldPutCardDeckOnTable() {
        // Given
        $cards = new CardCollection([
            new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT)
        ]);

        // When
        $table = new Table($cards);
        $actual = $table->getCardDeck();

        // Then
        $this->assertSame($cards, $actual);
    }
    
    public function testShouldAddCardCollectionToCardDeckOnTable() {
        // Given
        $cardCollection = new CardCollection([
            new Card(Card::COLOR_SPADE, Card::VALUE_FOUR),
            new Card(Card::COLOR_HEART, Card::VALUE_JACK)
        ]);
        // When
        $actual = $this->tableUnderTest->addCardCollectionToDeck($cardCollection);
    
        // Then
        $this->assertEquals($cardCollection, $actual->getCardDeck());
    }
}