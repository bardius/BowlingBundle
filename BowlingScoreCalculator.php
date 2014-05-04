<?php
/**
 * Ten-pin Bowling game score calculator
 *
 * Description:
 * This ten-pin bowling game score calculator solution is not the shortest possible solution.
 * 
 * It is based on the assumption that a score board must exist so all frames score history
 * during a game is available to display if needed, and that the total score calculation can
 * be done within a game in progress.
 * 
 * Additionaly it is not taken as a fact that the provided data is always proper, so it is tested.
 * 
 * Variables for calculation and game rule limits exist as variables so this calculator can be extended
 * to provide functionality for different rule sets (tweleve-pin bowling game etc).
 * 
 * The logic is that we have an array that holds the dropped pins per roll that we can get, set, fill or clear
 * an array of the frame scores that we can get, set, fill based on the dropped pins array or clear and 
 * functionality to calculate each frame score (open frame, spare or strike) and total score of all
 * available frames.
 * 
 * PHPUnit tests exist for ensuring proper fnctionality.
 *
 * @category    Experiment
 * @package     Bowling_Test
 * @subpackage  BowlingScoreCalculator_Test
 * @author      George Bardis <george@bardis.info>
 * @copyright   Copyright (c) 2013 George Bardis (http://www.bardis.info)
 * @version     $Id:$
 * @since       File available since Release 0.0.1
 */

namespace Bardis\BowlingBundle;

/**
 * Class to hold and calculate the game score of a ten-pin bowling game
 *
 * @category    Experiment
 * @package     Bowling_Test
 * @subpackage  BowlingScoreCalculator_Test
 * @author      George Bardis <george@bardis.info>
 * @copyright   Copyright (c) 2013 George Bardis (http://www.bardis.info)
 * @version     $Id:$
 * @since       Class available since Release 0.0.1
 */
class BowlingScoreCalculator
{
    protected $droppedPins          = array();  // the array that holds the dropped pins for each roll the player did
    protected $gameScoreBoard       = array();  // the array that holds the score for each frame    
    protected $maxRollsPerGame      = 21;       // the maximum total rolls per game   
    protected $maxFramesPerGame     = 10;       // the maximum total frames per game
    protected $maxGameScore         = 300;      // the maximum total score per game
    protected $allRollPins          = 10;       // the maximum total pins in roll
    
    
    /**
     * Calculate and provide the total game score
     *
     * @return integer $totalScore Total game score
     */
    public function calcTotalGameScore()
    {  
        $totalScore = array_sum($this->getGameScoreBoard());
        
        return $totalScore;
    }
    
    
    /**
     * Calculate and store the individual frames score
     * 
     * For each roll in droppedPins array calculate the frame score based on game rules 
     * and proceed to next frames' first roll, storing the values to gameScoreBoard.
     *
     * @return boolean True if scores have been calculated and stored with success
     */
    public function fillGameScoreBoard()
    {        
        $rollsCount = count($this->getGameDroppedPins());
        
        if($rollsCount > $this->maxRollsPerGame)
        {
            return false;            
        }
        
        for ($roll = 0, $frame = 0; $roll < $rollsCount; $roll++, $frame++) {
            if($frame < $this->maxFramesPerGame){
                if($this->getRollDroppedPins($roll) == $this->allRollPins){
                    $this->gameScoreBoard[$frame] = $this->calcStrikeScore($roll);
                }
                else
                {
                    $this->gameScoreBoard[$frame] = $this->calcOpenFrameScore($roll);

                    if($this->gameScoreBoard[$frame] == $this->allRollPins){
                        $this->gameScoreBoard[$frame] = $this->calcSpareScore($roll);
                    }

                    $roll++;
                }
            }
            else
            {
                break; 
            }
        }
            
        return true;
    }
    
    
    /**
     * Calculate the score of a strike for a given roll
     *
     * @param   integer $roll  The roll to calculate strike score for
     * @return  integer $strikeScore The strike score for the given roll
     */
    public function calcStrikeScore($roll)
    {
        $strikeScore = $this->allRollPins;
        $strikeScore += $this->getRollDroppedPins($roll + 1) + $this->getRollDroppedPins($roll + 2);
            
        
        return $strikeScore;
    }  
    
    
    /**
     * Calculate the score of a spare for a given roll
     *
     * @param   integer $roll  The roll to calculate spare score for
     * @return  integer $spareScore The spare score for the given roll
     */
    public function calcSpareScore($roll)
    {   
        $spareScore = $this->allRollPins + $this->getRollDroppedPins($roll + 2);
        
        return $spareScore;
    }
    
    
    /**
     * Calculate the score of an open frame for a given roll
     *
     * @param   integer $roll  The roll to calculate open frame score for
     * @return  integer $openFrameScore The open frame score for the given roll
     */
    public function calcOpenFrameScore($roll)
    {
        $openFrameScore = $this->getRollDroppedPins($roll) + $this->getRollDroppedPins($roll + 1);
        
        return $openFrameScore;
    }  
    
    
    /**
     * Set an array of frame scores for a game
     *
     * @param   array   $frameScoresData  Array of frame scores
     * @return  boolean True if scores have been set with success
     */
    public function setGameScoreBoard($frameScoresData)
    {
        if(array_sum($frameScoresData) > $this->maxGameScore || count($frameScoresData) > $this->maxFramesPerGame)
        {
            return false;
        }
        
        $this->gameScoreBoard = $frameScoresData;
        
        return true;
    }    
    
    
    /**
     * Clear the array of frame scores for a game
     */
    public function resetGameScoreBoard()
    {
        $this->gameScoreBoard = array();
    }
    
    
    /**
     * Get the array of frame scores for a game
     *
     * @return  array The frame scores for a game
     */
    public function getGameScoreBoard()
    {
        return $this->gameScoreBoard;
    }  
    
    
    /**
     * Set an array of dropped pins value per roll for a game
     *
     * @param   array   $rollScoresData  Array of dropped pins scores
     * @return  boolean True if scores have been set with success
     */
    public function setGameDroppedPins($rollScoresData)
    {        
        if(count($rollScoresData) > $this->maxRollsPerGame)
        {
            return false;
        }
        
        $this->droppedPins = $rollScoresData;
        
        return true;
    }
    
    
    /**
     * Clear the array of dropped pins value per roll for a game
     */
    public function resetGameDroppedPins()
    {
        $this->droppedPins = array();
    }  
    
    
    /**
     * Get the array of dropped pins value per roll for a game
     *
     * @return  array The dropped pins value per roll for a game
     */
    public function getGameDroppedPins()
    {
        return $this->droppedPins;
    }
    
    
    /**
     * Set the value of dropped pins for a roll
     *
     * @param   integer $roll The roll to set dropped pins to
     * @param   integer $rollScore The dropped pins score
     * @return  boolean True if score have been set with success
     */
    public function setRollDroppedPins($roll, $rollScore)
    {     
        if(0 < $roll && $roll < $this->maxRollsPerGame && 0 < $rollScore && $rollScore <= $this->allRollPins )
        {        
            $this->droppedPins[$roll] = $rollScore;
            return true;
        }        
        
        return false;
    }
    
    /**
     * Get the value of dropped pins for a roll
     *
     * @param   integer $roll The roll to get dropperd pins for
     * @return  integer The dropped pins value of the roll
     */
    public function getRollDroppedPins($roll)
    {
        if(!isset($this->droppedPins[$roll]))
        {
            return 0;            
        }
        
        return $this->droppedPins[$roll];
    }
    
}