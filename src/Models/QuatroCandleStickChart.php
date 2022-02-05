<?php

namespace Reccur\Candlestick\Models;

class QuatroCandleStickChart{

    public $candle1;
    public $candle2;
    public $candle3;
    public $candle4;

    public $pattern;
    public $accuracy;
    
    public function __construct($candle1, $candle2, $candle3, $candle4){
        $this->candle1 = $candle1;
        $this->candle2 = $candle2;
        $this->candle3 = $candle3;
        $this->candle4 = $candle4;
        $this->setPattern();
    }

    public function pattern(){
        return $this->pattern;
    }

    public function accuracy(){
        return $this->accuracy;
    }

    public function setPattern(){
        
        // BULLISH_THREE_LINE_STRIKE
        if(
            ($this->candle1->color=="RED") &&
            ($this->candle2->color=="RED") &&
            ($this->candle3->color=="RED") &&
            ($this->candle1->c > $this->candle2->c) &&
            ($this->candle2->c > $this->candle3->c) &&
            ($this->candle4->color=="GREEN") &&
            (($this->candle4->c > $this->candle1->o) && ($this->candle4->o < $this->candle3->c))
        ){
            $this->pattern = "BULLISH_THREE_LINE_STRIKE";
            $this->accuracy = "83";
        }

        // BEARISH_THREE_LINE_STRIKE
        if(
            ($this->candle1->color=="GREEN") &&
            ($this->candle2->color=="GREEN") &&
            ($this->candle3->color=="GREEN") &&
            ($this->candle2->c > $this->candle1->c) &&
            ($this->candle3->c > $this->candle2->c) &&
            ($this->candle4->color=="RED") &&
            (($this->candle4->o > $this->candle3->c) && ($this->candle4->c < $this->candle1->o))
        ){
            $this->pattern = "BEARISH_THREE_LINE_STRIKE";
            $this->accuracy = "83";
        }

    }

}