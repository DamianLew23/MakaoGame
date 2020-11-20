<?php


namespace Test\Makao\Collection;


use Makao\Card;
use Makao\Collection\CardCollection;
use Makao\Exception\CardNotFoundException;
use Makao\Exception\MethodNotAllowedException;
use PHPUnit\Framework\TestCase;

class CardCollectionTest extends TestCase
{
    /** @var CardCollection  */
    private $cardCollectionUnderTest;

    public function setUp()
    {
        $this->cardCollectionUnderTest = new CardCollection();
    }

    public function testShouldReturnZeroOnEmptyCollection() {
        // Then
        $this->assertCount(0, $this->cardCollectionUnderTest);
    }

    public function testShouldAddNewCardToCardCollection() {
        // Given
        $card = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);

        // When
        $this->cardCollectionUnderTest->add($card);
        // Then
        $this->assertCount(1, $this->cardCollectionUnderTest);
    }

    public function testShouldAddNewCardsInChainToCardCollection() {
        // Given
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        $secondCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);

        // When
        $this->cardCollectionUnderTest
            ->add($firstCard)
            ->add($secondCard);
        // Then
        $this->assertCount(2, $this->cardCollectionUnderTest);
    }

    public function testShouldThrowCardNotFountExceptionWhenITryPeekCardFromEmptyCardCollection() {
        // Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('You can not pick card from empty CardCollection');

        // When
        $this->cardCollectionUnderTest->pickCard();
    }

    public function testShouldIterableOnCardCollection() {
        // Given
        $card = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);

        // When & Then
        $this->cardCollectionUnderTest->add($card);

        $this->assertTrue($this->cardCollectionUnderTest->valid());
        $this->assertSame($card, $this->cardCollectionUnderTest->current());
        $this->assertSame(0, $this->cardCollectionUnderTest->key());

        $this->cardCollectionUnderTest->next();
        $this->assertFalse($this->cardCollectionUnderTest->valid());
        $this->assertSame(1, $this->cardCollectionUnderTest->key());

        $this->cardCollectionUnderTest->rewind();
        $this->assertTrue($this->cardCollectionUnderTest->valid());
        $this->assertSame($card, $this->cardCollectionUnderTest->current());
        $this->assertSame(0, $this->cardCollectionUnderTest->key());
    }

    public function testShouldGetFirstCardFromCardCollectionAndRemoveThisCardFromDeck() {
        // Given
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        $secondCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        $this->cardCollectionUnderTest
            ->add($firstCard)
            ->add($secondCard);

        // When
        $actual = $this->cardCollectionUnderTest->pickCard();

        // Then
        $this->assertCount(1, $this->cardCollectionUnderTest);
        $this->assertSame($firstCard, $actual);
        $this->assertSame($secondCard, $this->cardCollectionUnderTest[0]);

    }
    
    public function testShouldThrowCardNotFoundExceptionWhenIPickedAllCardFromCardCollection() {
        // Expect
        $this->expectException(CardNotFoundException::class);
        $this->expectExceptionMessage('You can not pick card from empty CardCollection');

        // Given
        $firstCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        $secondCard = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        $this->cardCollectionUnderTest
            ->add($firstCard)
            ->add($secondCard);
    
        // When
        $actual = $this->cardCollectionUnderTest->pickCard();
        $this->assertSame($firstCard, $actual);

        $actual = $this->cardCollectionUnderTest->pickCard();
        $this->assertSame($secondCard, $actual);

        $this->cardCollectionUnderTest->pickCard();
    }

    public function testShouldThrowMethodNotAllowedExceptionWhenYouTryAddCardToCollectionAsArray() {
        // Expect
        $this->expectException(MethodNotAllowedException::class);
        $this->expectExceptionMessage('You can not add card to collection as array. Use addCard() method!');
        // Given
        $card = new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT);
        // When
        $this->cardCollectionUnderTest[] = $card;
    }

    public function testShouldReturnCollectionAsArray() {
        // Given
        $cards = [
            new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT),
            new Card(Card::COLOR_CLUB, Card::VALUE_EIGHT)
        ];

        // When
        $actual = new CardCollection($cards);

        // Then
        $this->assertEquals($cards, $actual->toArray());
    }
}