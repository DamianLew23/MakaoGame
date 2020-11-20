<?php


namespace Makao\Service;


use PHPUnit\Framework\TestCase;

class GameServiceTest extends TestCase
{
    /** @var GameService  */
    private $gameService;

    protected function setUp()
    {
        $this->gameService = new GameService();
    }

    public function testShouldReturnFalseWhenGameIsNotStarted() {
        // When
        $actual = $this->gameService->isStarted();
        // Then
        $this->assertFalse($actual);
    }
    
    public function testShouldInitNewGameWithEmptyTable() {
        // Given

        // When
    
        // Then
    }
}