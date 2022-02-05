<?php

namespace Reccur\Candlestick\Models;

class DualCandleStickChart{

    public $candle1;
    public $candle2;

    public $PATTERN;
    
    public function __construct($candle1, $candle2){
        $this->candle1 = $candle1;
        $this->candle2 = $candle2;
        $this->setPattern();
    }

    public function pattern(){
        return $this->PATTERN;
    }

    public function setPattern(){

        // BULLISH_KICKER
        if(
            ($this->candle1->PATTERN=="MARUBOZU" && $this->candle1->color=="RED") &&
            ($this->candle2->PATTERN=="MARUBOZU" && $this->candle2->color=="GREEN") &&
            ($this->candle1->o < $this->candle2->o) &&
            ($this->candle1->volume < $this->candle2->volume)
        ){
            $this->PATTERN = "BULLISH_KICKER";
        }

        // BEARISH_KICKER
        if(
            ($this->candle1->PATTERN=="MARUBOZU" && $this->candle1->color=="GREEN") &&
            ($this->candle2->PATTERN=="MARUBOZU" && $this->candle2->color=="RED") &&
            ($this->candle1->o > $this->candle2->o) &&
            ($this->candle1->volume > $this->candle2->volume)
        ){
            $this->PATTERN = "BULLISH_KICKER";
            
        }

        // BULLISH_ENGULFING
        if(
            ($this->candle1->color=="RED" && $this->candle2->color=="GREEN") &&
            ($this->candle1->o < $this->candle2->c) &&
            ($this->candle1->c > $this->candle2->o) &&
            ($this->candle1->volume < $this->candle2->volume)

        ){
            $this->PATTERN = "BULLISH_ENGULFING";
        }

        // BEARISH_ENGULFING
        if(
            ($this->candle1->color=="GREEN" && $this->candle2->color=="RED") &&
            ($this->candle1->c < $this->candle2->o) &&
            ($this->candle1->o > $this->candle2->c) &&
            ($this->candle1->volume > $this->candle2->volume)

        ){
            $this->PATTERN = "BEARISH_ENGULFING";
        }

        // BULLISH_HARAMI
        if(
            ($this->candle1->color=="RED" && $this->candle2->color=="GREEN") &&
            ($this->candle1->o > $this->candle2->c) &&
            ($this->candle1->c < $this->candle2->o)

        ){
            $this->PATTERN = "BULLISH_HARAMI";
        }

        // BEARISH_HARAMI
        if(
            ($this->candle1->color=="GREEN" && $this->candle2->color=="RED") &&
            ($this->candle1->o < $this->candle2->c) &&
            ($this->candle1->c > $this->candle2->o)

        ){
            $this->PATTERN = "BEARISH_HARAMI";
        }

        // PIERCING_LINE
        if(
            ($this->candle1->color=="RED" && $this->candle2->color=="GREEN") &&
            ($this->candle1->c > $this->candle2->o) &&
            ($this->candle1->o > $this->candle2->c) &&
            (($this->candle1->o + $this->candle1->c) / 2 < $this->candle2->c)
        ){
            $this->PATTERN = "PIERCING_LINE";
        }

        // DARK_CLOUD_COVER
        if(
            ($this->candle1->color=="GREEN" && $this->candle2->color=="RED") &&
            ($this->candle1->c < $this->candle2->o) &&
            ($this->candle1->o < $this->candle2->c) &&
            (($this->candle1->o + $this->candle1->c) / 2 > $this->candle2->c)
        ){
            $this->PATTERN = "DARK_CLOUD_COVER";
        }

        // TWEEZER_BOTTOM
        if(
            ($this->candle1->color=="RED" && $this->candle2->color=="GREEN") &&
            ($this->candle1->c == $this->candle2->o)
        ){
            $this->PATTERN = "TWEEZER_BOTTOM";
        }

        // TWEEZER_TOP
        if(
            ($this->candle1->color=="GREEN" && $this->candle2->color=="RED") &&
            ($this->candle1->c == $this->candle2->o)
        ){
            $this->PATTERN = "TWEEZER_TOP";
        }
    }

}