<?php

namespace Reccur\Candlestick\Models;

class TripleCandleStickChart{

    public $candle1;
    public $candle2;
    public $candle3;

    public $PATTERN;
    
    public function __construct($candle1, $candle2, $candle3){
        $this->candle1 = $candle1;
        $this->candle2 = $candle2;
        $this->candle3 = $candle3;
        $this->setPattern();
    }

    public function pattern(){
        return $this->PATTERN;
    }

    public function setPattern(){
        
        // MORNING_STAR
        if(
            ($this->candle1->color=="RED") &&
            ($this->candle1->c > max($this->candle2->o, $this->candle2->c)) &&
            ($this->candle3->o > max($this->candle2->o, $this->candle2->c)) &&
            ($this->candle3->color=="GREEN") &&
            (($this->candle1->o + $this->candle1->c) / 2 < $this->candle3->c)
        ){
            $this->PATTERN = "MORNING_STAR";
            if(
                ($this->candle2->PATTERN=="DOJI") &&
                ($this->candle1->l > $this->candle2->h)
            ){
                $this->PATTERN = "BULLISH_ABANDONED_BABY";
            }
            
        }

        // EVENING_STAR
        if(
            ($this->candle1->color=="GREEN") &&
            ($this->candle1->c < max($this->candle2->o, $this->candle2->c)) &&
            ($this->candle3->o < min($this->candle2->o, $this->candle2->c)) &&
            ($this->candle3->color=="RED") &&
            (($this->candle1->o + $this->candle1->c) / 2 > $this->candle3->c)
        ){
            $this->PATTERN = "EVENING_STAR";
            if(
                ($this->candle2->PATTERN=="DOJI") &&
                ($this->candle1->h < $this->candle2->l)
            ){
                $this->PATTERN = "BEARISH_ABANDONED_BABY";
            }
        }

        // THREE_WHITE_SOLDIERS
        if(
            ($this->candle1->color=="GREEN") &&
            ($this->candle2->color=="GREEN") &&
            ($this->candle3->color=="GREEN") &&
            ($this->candle2->o > $this->candle1->o) && ($this->candle2->o < $this->candle1->c) &&
            ($this->candle2->c > $this->candle3->o) && ($this->candle2->c > $this->candle3->o) &&
            ($this->candle3->c > $this->candle2->c)
        ){
            $this->PATTERN = "THREE_WHITE_SOLDIERS";    
        }

        // THREE_BLACK_CROWS
        if(
            ($this->candle1->color=="RED") &&
            ($this->candle2->color=="RED") &&
            ($this->candle3->color=="RED") &&
            ($this->candle1->o > $this->candle2->o) && 
            ($this->candle1->c < $this->candle2->o) &&
            ($this->candle2->c < $this->candle3->o) && 
            ($this->candle3->c < $this->candle2->c)
        ){
            $this->PATTERN = "THREE_BLACK_CROWS";    
        }

        // THREE_OUTSIDE_UP
        $dcscTOU = new DualCandleStickChart($this->candle1, $this->candle2);
        if(
            ($dcscTOU->PATTERN=="BULLISH_ENGULFING") &&
            ($this->candle3->color=="GREEN") &&
            ($this->candle3->c > $this->candle2->c) &&
            ($this->candle2->volume < $this->candle3->volume)
        ){
            $this->PATTERN = "THREE_OUTSIDE_UP";
        }

        // THREE_OUTSIDE_DOWN
        $dcscTOD = new DualCandleStickChart($this->candle1, $this->candle2);
        if(
            ($dcscTOD->PATTERN=="BEARISH_ENGULFING") &&
            ($this->candle3->color=="RED") &&
            ($this->candle3->c < $this->candle2->c) &&
            ($this->candle2->volume > $this->candle3->volume)
        ){
            $this->PATTERN = "THREE_OUTSIDE_DOWN";
        }

        // THREE_INSIDE_UP
        $dcscTOU = new DualCandleStickChart($this->candle1, $this->candle2);
        if(
            ($dcscTOU->PATTERN=="BULLISH_HARAMI") &&
            ($this->candle3->color=="GREEN") &&
            ($this->candle3->c > $this->candle2->c) &&
            ($this->candle2->volume < $this->candle3->volume)
        ){
            $this->PATTERN = "THREE_INSIDE_UP";
        }

        // THREE_INSIDE_DOWN
        $dcscTOU = new DualCandleStickChart($this->candle1, $this->candle2);
        if(
            ($dcscTOU->PATTERN=="BEARISH_HARAMI") &&
            ($this->candle3->color=="RED") &&
            ($this->candle3->c < $this->candle2->c) &&
            ($this->candle2->volume > $this->candle3->volume)
        ){
            $this->PATTERN = "THREE_INSIDE_DOWN";
        }

        // DARK_CLOUD_COVER_CONFIRMED
        $dcscDCCC = new DualCandleStickChart($this->candle1, $this->candle2);
        if(
            ($dcscTOU->PATTERN=="DARK_CLOUD_COVER") &&
            ($this->candle3->color=="RED") &&
            ($this->candle2->o > $this->candle3->o) &&
            ($this->candle2->volume > $this->candle3->volume)
        ){
            $this->PATTERN = "DARK_CLOUD_COVER_CONFIRMED";
        }
    }

}