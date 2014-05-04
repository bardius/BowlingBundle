<?php

require dirname(__FILE__).'/../BowlingScoreCalculator.php';

use Bardis\BowlingBundle\BowlingScoreCalculator;

class BowlingScoreCalculatorTest extends PHPUnit_Framework_TestCase
{     
    /**
     * Test to properly ensure that the setGameDroppedPins function is working as intented
     */
    public function testSetGameDroppedPins()
    {
        $testBowlingGame        = new BowlingScoreCalculator;  
        
        // Testing for empty array of roll dropped pins
        $testRollScores         = array();        
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);        
        
        // Testing for array of roll dropped pins with more rolls than the maximum
        $testRollScores         = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);        
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertFalse($gameDroppedPinsSet);     
        
        // Testing for array of one roll dropped pins
        $testRollScores         = array(0);         
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);   
        
        // Testing for array of maximum rolls dropped pins
        $testRollScores         = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);          
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);     
    }
    
    /**
     * Test to properly ensure that the fillGameScoreBoard function is working as intented
     * and the frame scores are properly calculated after input of dropping pins per roll
     */
    public function testFillGameScoreBoard()
    {
        $testBowlingGame        = new BowlingScoreCalculator;
        
        // Testing for dropped pins input array for a Gutter game   
        $testRollScores         = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);         
        // Test providing input from setGameDroppedPins     
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);    
        $this->assertTrue($gameDroppedPinsSet);
        // Testing the fillGameScoreBoard after the inpuy was from the setGameDroppedPins
        $testFillGameScoreBoard = $testBowlingGame->fillGameScoreBoard();        
        $this->assertTrue($testFillGameScoreBoard); 
        // Testing the calcTotalGameScore after the inpuy was from the setGameDroppedPins
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 0);   
        
        // Testing for dropped pins input array for a full of spares game without bonus last roll
        $testRollScores         = array(9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1);
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        // Testing the fillGameScoreBoard after the inpuy was from the setGameDroppedPins
        $testFillGameScoreBoard = $testBowlingGame->fillGameScoreBoard();        
        $this->assertTrue($testFillGameScoreBoard);   
        // Testing the calcTotalGameScore after the inpuy was from the setGameDroppedPins
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 181);  
        
        // Testing for dropped pins input array for a full of spares game and open last frame
        $testRollScores         = array(9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9, 1, 9);
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        // Testing the fillGameScoreBoard after the inpuy was from the setGameDroppedPins
        $testFillGameScoreBoard = $testBowlingGame->fillGameScoreBoard();        
        $this->assertTrue($testFillGameScoreBoard);   
        // Testing the calcTotalGameScore after the inpuy was from the setGameDroppedPins
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 190);   
        
        // Testing for dropped pins input array for a full of strikes game without the last two bonus rolls
        $testRollScores         = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10);
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        // Testing the fillGameScoreBoard after the inpuy was from the setGameDroppedPins
        $testFillGameScoreBoard = $testBowlingGame->fillGameScoreBoard();        
        $this->assertTrue($testFillGameScoreBoard);       
        // Testing the calcTotalGameScore after the inpuy was from the setGameDroppedPins
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 270); 
        
        // Testing for dropped pins input array for a full of strikes game
        $testRollScores         = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10);
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        // Testing the fillGameScoreBoard after the inpuy was from the setGameDroppedPins
        $testFillGameScoreBoard = $testBowlingGame->fillGameScoreBoard();        
        $this->assertTrue($testFillGameScoreBoard);       
        // Testing the calcTotalGameScore after the inpuy was from the setGameDroppedPins
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 300);      
    }
    
    /**
     * Test to properly ensure that the setGameScoreBoard function is working as intented
     */
    public function testSetGameScoreBoard()
    {
        $testBowlingGame        = new BowlingScoreCalculator;  
        
        // Testing for empty array of frame scores
        $testFrameScores        = array();        
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);        
        
        // Testing for array of frame scores with more frames than the maximum
        $testFrameScores        = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11);        
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertFalse($gameScoreBoardisSet);      
        
        // Testing for empty array of frame scores with one frame
        $testFrameScores        = array(0);        
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);        
        
        // Testing for empty array of frame scores with total score more than maximum
        $testFrameScores        = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 301);        
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertFalse($gameScoreBoardisSet);   
        
        // Testing for empty array of frame scores with minimum total score
        $testFrameScores        = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);         
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);         
        
        // Testing for empty array of frame scores with maximum total score
        $testFrameScores        = array(30, 30, 30, 30, 30, 30, 30, 30, 30, 30);          
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);      
    }
    
    /**
     * Test to properly ensure that the calcTotalGameScore function is working as intented for gutter game
     * if frame score array is given as data to setGameScoreBoard
     */
    public function testGutterCalcTotalGameScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;
        $testFrameScores        = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        
        // Test providing input from setGameScoreBoard   
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);
        
        // Testing the calcTotalGameScore after the input was from the setGameScoreBoard
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 0);        
    }
    
    /**
     * Test to properly ensure that the calcTotalGameScore function is working as intented for perfect game
     * if frame score array is given as data to setGameScoreBoards
     */
    public function testPerfectCalcTotalGameScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;        
        $testFrameScores        = array(30, 30, 30, 30, 30, 30, 30, 30, 30, 30);
        
        // Test providing input from setGameScoreBoard 
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);
        
        // Testing the calcTotalGameScore after the input was from the setGameScoreBoard
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 300);        
    }
    
    /**
     * Test to properly ensure that the calcTotalGameScore function is working as intented for no spare no strike game
     * if frame score array is given as data to setGameScoreBoards
     */
    public function testNormalCalcTotalGameScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;        
        $testFrameScores        = array(9, 9, 9, 9, 9, 9, 9, 9, 9, 9);
        
        // Test providing input from setGameScoreBoard 
        $gameScoreBoardisSet    = $testBowlingGame->setGameScoreBoard($testFrameScores);        
        $this->assertTrue($gameScoreBoardisSet);
        
        // Testing the calcTotalGameScore after the input was from the setGameScoreBoard
        $testTotalGameScore     = $testBowlingGame->calcTotalGameScore();
        $this->assertEquals($testTotalGameScore, 90);        
    }
    
    /**
     * Test to properly ensure that the calcStrikeScore function is working as intented     * 
     */
    public function testCalcStrikeScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;        
        
        // Testing for dropped pins input array
        $testRollScores         = array(9, 10, 9, 8, 9, 9, 9, 9, 9, 9, 9, 9);
        
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        
        // Testing the calcStrikeScore
        $testStrikeScore        = $testBowlingGame->calcStrikeScore(2);
        $this->assertEquals($testStrikeScore, 27);        
    }
    
    /**
     * Test to properly ensure that the calcSpareScore function is working as intented
     */
    public function testCalcSpareScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;        
        
        // Testing for dropped pins input array
        $testRollScores         = array(9, 0, 9, 1, 9, 0, 9, 0, 9, 0, 9, 0, 9, 0, 9, 0, 9, 0, 9, 0);
        
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        
        // Testing the calcStrikeScore
        $testSpareScore        = $testBowlingGame->calcSpareScore(2);
        $this->assertEquals($testSpareScore, 19);        
    }
    
    /**
     * Test to properly ensure that the calcOpenFrameScore function is working as intented
     */
    public function testCalcOpenFrameScore()
    {
        $testBowlingGame        = new BowlingScoreCalculator;        
        
        // Testing for dropped pins input array
        $testRollScores         = array(0, 0, 0, 0, 5, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        
        // Test providing input from setGameDroppedPins   
        $gameDroppedPinsSet     = $testBowlingGame->setGameDroppedPins($testRollScores);        
        $this->assertTrue($gameDroppedPinsSet);
        
        // Testing the calcOpenFrameScore
        $testSpareScore        = $testBowlingGame->calcOpenFrameScore(4);
        $this->assertEquals($testSpareScore, 9);        
    }
}