<?php

namespace Reccur\Candlestick\Models;

class Patterns{
    public $base;
    public $specific;
}

class Candle{

    public $date;
    public $o;
    public $h;
    public $l;
    public $c;
    public $volume;

    public $color;

    public $candle;
    public $upper_wick;
    public $body;
    public $lower_wick;
    public $wicks;

    public $pattern_base;
    public $pattern_specific;
    
    public function __construct($params){

        $this->date = (string) $params['date'] ?? '';
        $this->o = (float) $params['o'] ?? 0;
        $this->h = (float) $params['h'] ?? 0;
        $this->l = (float) $params['l'] ?? 0;
        $this->c = (float) $params['c'] ?? 0;
        $this->volume = (float) $params['volume'] ?? 0;

        $this->setColor();
        $this->setStructure();
        $this->setPatterns();
        
    }

    /* Getters */

    public function date(){
        return $this->date;
    }

    public function o() : float{
        return $this->o;
    }

    public function h() : float{
        return $this->h;
    }

    public function l() : float{
        return $this->l;
    }

    public function c() : float{
        return $this->c;
    }

    public function volume() : float{
        return $this->volume;
    }

    public function color(){
        return $this->color;
    }

    public function candle(){
        return $this->candle;
    }

    public function upper_wick(){
        return $this->upper_wick;
    }

    public function body(){
        return $this->body;
    }

    public function lower_wick(){
        return $this->lower_wick;
    }

    public function wicks(){
        return $this->wicks;
    }

    public function pattern_base(){
        return $this->pattern_base;
    }

    public function pattern_specific(){
        return $this->pattern_specific;
    }

    /* Getters */


    // setter for color
    public function setColor(){
        if($this->c == $this->o){
            $this->color = "TRUE_DOJI";
        } else {
            $this->color = $this->c > $this->o ? "GREEN":"RED";
        }
        return $this;
    }

    // setter for structure
    public function setStructure(){
        $upper_wick = $this->color=="GREEN"?($this->h - $this->c):($this->h - $this->o);
        $body = abs($this->o - $this->c);
        $lower_wick = $this->color=="GREEN"?($this->o - $this->l):($this->c - $this->l);

        $total_length = $upper_wick + $body + $lower_wick;

        $this->candle = 100;
        $this->upper_wick = round($upper_wick / $total_length * 100, 4);
        $this->body = round($body / $total_length * 100, 4);
        $this->lower_wick = round($lower_wick / $total_length * 100, 4);
        $this->wicks = round(100 - $this->body, 4);
    }

    public function setPatterns(){

        // DOJI : 20 * ABS(O - C) <= H - L
        if( (config('candlestick.DOJI_WICK_MULTIPLIER') * abs($this->o - $this->c)) <= ($this->h - $this->l) ){
            $this->pattern_base = "DOJI";
        }

        // DOJI_DRAGONFLY
        if(
            ($this->lower_wick > config('candlestick.DOJI_WICK_MULTIPLIER') * $this->body) && 
            ($this->upper_wick <= config('candlestick.DOJI_SHORTER_WICK_THRESHOLD'))
        ){
            $this->pattern_specific = "DRAGONFLY";
        }

        // DOJI_GRAVESTONE
        if(
            ($this->upper_wick > config('candlestick.DOJI_WICK_MULTIPLIER') * $this->body) && 
            ($this->lower_wick <= config('candlestick.DOJI_SHORTER_WICK_THRESHOLD'))
        ){
            $this->pattern_specific = "GRAVESTONE";
        }

        // MARUBOZU : Must be a long candle without any wicks
        if(
            ($this->body == 100) && 
            (config('candlestick.MARUBOZU_MULTIPLIER') * abs($this->o - $this->c) >= (($this->o + $this->c)) / 2)
        ){
            $this->pattern_base = "MARUBOZU";
            $this->pattern_specific = "FULL";
        }

        // CLOSING_MARUBOZU : (L = C OR C = H) AND H - L > ABS(O - C)
        if(
            ($this->l == $this->c || $this->c == $this->h) &&
            $this->h - $this->l > abs($this->o - $this->c) &&
            $this->wicks > 0
        ){
            $this->pattern_base = "MARUBOZU";
            $this->pattern_specific = "CLOSING";
        }

        // OPENING_MARUBOZU : (L = O OR O = H) AND H - L > ABS(O - C)
        if(
            ($this->l == $this->o || $this->o == $this->h) && 
            $this->h - $this->l > abs($this->o - $this->c) &&
            $this->wicks > 0
        ){
            $this->pattern_base = "MARUBOZU";
            $this->pattern_specific = "OPENING";
        }

        // HAMMER_OR_HANGING_MAN
        if(
            ($this->lower_wick > config('candlestick.HANGING_MAN_LONGER_WICK_THRESHOLD')) && 
            ($this->upper_wick < config('candlestick.HANGING_MAN_SHORTER_WICK_THRESHOLD'))
        ){
            $this->pattern_base = "HANGING_MAN";
        }

        // // INVERTED_HAMMER_OR_SHOOTING_STAR
        if(
            ($this->upper_wick > config('candlestick.SHOOTING_STAR_LONGER_WICK_THRESHOLD')) && 
            ($this->lower_wick < config('candlestick.SHOOTING_STAR_LONGER_WICK_THRESHOLD'))
        ){
            $this->pattern_base = "SHOOTING_STAR";
        }

        // SPINNING_TOP
        if(
            ($this->body < config('candlestick.SPINNING_TOP_BODY_THRESHOLD')) && 
            abs($this->upper_wick - $this->lower_wick) < config('candlestick.SPINNING_TOP_WICKS_DIFFERENCE_THRESHOLD')
        ){
            $this->pattern_base = "SPINNING_TOP";
            if($this->upper_wick == $this->lower_wick){
                $this->pattern_specific = "CENTERED";
            } else {
                $this->pattern_specific = "OFFSET";
            }
        }


    }

}
?>