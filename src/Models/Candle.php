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

    public $pattern;
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

    public function pattern(){
        return $this->pattern;
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
        
        if($total_length > 0){
            $this->candle = 100;
            $this->upper_wick = round($upper_wick / $total_length * 100, 4);
            $this->body = round($body / $total_length * 100, 4);
            $this->lower_wick = round($lower_wick / $total_length * 100, 4);
            $this->wicks = round(100 - $this->body, 4);
        }
        
    }

    public function setPatterns(){

        // SPINNING_TOP
        if(
            ($this->body < config('candlestick.SPINNING_TOP_BODY_THRESHOLD')) && 
            abs($this->upper_wick - $this->lower_wick) < config('candlestick.SPINNING_TOP_WICKS_DIFFERENCE_THRESHOLD')
        ){
            $this->pattern = "SPINNING_TOP";
            if($this->upper_wick == $this->lower_wick){
                $this->pattern_specific = "CENTERED";
            } else {
                $this->pattern_specific = "OFFSET";
            }
        }

        /* DOJI START */
        // DOJI
        if($this->body < config('candlestick.DOJI_BODY_THRESHOLD')){
            $this->pattern = "DOJI";
            if(abs($this->upper_wick - $this->lower_wick) < 10){
                $this->pattern_specific = "LONG_LEGGED";
            }
        }

        // FOUR_PRICE
        if($this->o == $this->h && $this->h == $this->l && $this->l == $this->c){
            $this->pattern_specific = "FOUR_PRICE";
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
        /* DOJI END */


        /* MARUBOZU START */
        // MARUBOZU : Must be a long candle without any wicks
        if(
            ($this->body == 100) && 
            (config('candlestick.MARUBOZU_MULTIPLIER') * abs($this->o - $this->c) >= (($this->o + $this->c)) / 2)
        ){
            $this->pattern = "MARUBOZU";
            $this->pattern_specific = "FULL";
        }

        // CLOSING_MARUBOZU : (L = C OR C = H) AND H - L > ABS(O - C)
        if(
            ($this->l == $this->c || $this->c == $this->h) &&
            $this->h - $this->l > abs($this->o - $this->c) &&
            $this->wicks > 0
        ){
            $this->pattern = "MARUBOZU";
            $this->pattern_specific = "CLOSING";
        }

        // OPENING_MARUBOZU : (L = O OR O = H) AND H - L > ABS(O - C)
        if(
            ($this->l == $this->o || $this->o == $this->h) && 
            $this->h - $this->l > abs($this->o - $this->c) &&
            $this->wicks > 0
        ){
            $this->pattern = "MARUBOZU";
            $this->pattern_specific = "OPENING";
        }
        /* MARUBOZU END */

        if($this->body > $this->upper_wick && $this->body > $this->lower_wick){
            $this->pattern = "LONG";
        }

        // HAMMER_OR_HANGING_MAN
        if(
            ($this->lower_wick > config('candlestick.HAMMER_OR_HANGING_MAN_LONGER_WICK_THRESHOLD')) && 
            ($this->upper_wick < config('candlestick.HAMMER_OR_HANGING_MAN_SHORTER_WICK_THRESHOLD'))
        ){
            $this->pattern = "HAMMER_OR_HANGING_MANHAMMER_OR_HANGING_MAN";
        }

        // INVERTED_HAMMER_OR_SHOOTING_STAR
        if(
            ($this->upper_wick > config('candlestick.SHOOTING_STAR_LONGER_WICK_THRESHOLD')) && 
            ($this->lower_wick < config('candlestick.SHOOTING_STAR_LONGER_WICK_THRESHOLD'))
        ){
            $this->pattern = "SHOOTING_STAR";
        }

    }
}
?>