<?php

namespace Reccur\Candlestick\Models;

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

        public $PATTERN;
        
        public function __construct($params){

            $this->date = $params['date'] ?? '';
            $this->o = $params['o'] ?? 0;
            $this->h = $params['h'] ?? 0;
            $this->l = $params['l'] ?? 0;
            $this->c = $params['c'] ?? 0;
            $this->volume = $params['volume'] ?? 0;

            $this->setColor();
            $this->setStructure();
            $this->setPattern();
            
        }

        /* Getters */

        public function date(){
            return $this->date;
        }

        public function o(){
            return $this->o;
        }

        public function h(){
            return $this->h;
        }

        public function l(){
            return $this->l;
        }

        public function c(){
            return $this->c;
        }

        public function volume(){
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
            return $this->PATTERN;
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

        public function setStructure(){
            $upper_wick = $this->color=="GREEN"?($this->h - $this->c):($this->h - $this->o);
            $body = abs($this->o - $this->c);
            $lower_wick = $this->color=="GREEN"?($this->o - $this->l):($this->c - $this->l);

            $total_length = $upper_wick + $body + $lower_wick;

            $this->candle = 100;
            $this->upper_wick = round($upper_wick / $total_length * 100);
            $this->body = round($body / $total_length * 100);
            $this->lower_wick = round($lower_wick / $total_length * 100);
            $this->wicks = 100 - $this->body;
        }

        public function stats(){
 
            if( $this->PATTERN == "MARUBOZU" ){

                echo "date : {$this->date}<br>";
                echo "color : {$this->color}<br>";
                echo "pattern : {$this->PATTERN}<br>";
                echo "upper_wick : {$this->upper_wick}<br>";
                echo "body : {$this->body}<br>";
                echo "lower_wick : {$this->lower_wick}<br>";
                echo "<br>";
            }
        }

        public function setPattern(){

            // DOJI : 20 * ABS(O - C) <= H - L
            if( (config('candlestick.DOJI_WICK_MULTIPLIER') * abs($this->o - $this->c)) <= ($this->h - $this->l) ){
                $this->PATTERN = "DOJI";
            }

            // MARUBOZU : ABS(H - L) = ABS(O - C)
            if( $this->body == 100 ){
                $this->PATTERN = "MARUBOZU";
            }

            // CLOSING_MARUBOZU : (L = C OR C = H) AND H - L > ABS(O - C)
            if(
                ($this->l == $this->c || $this->c == $this->h) &&
                $this->h - $this->l > abs($this->o - $this->c) &&
                $this->wicks < config('candlestick.MARUBOZU_WICKS_THRESHOLD')
            ){
                $this->PATTERN = "CLOSING_MARUBOZU";
            }

            // OPENING_MARUBOZU : (L = O OR O = H) AND H - L > ABS(O - C)
            if(
                ($this->l == $this->o || $this->o == $this->h) && 
                $this->h - $this->l > abs($this->o - $this->c) &&
                $this->wicks < config('candlestick.MARUBOZU_WICKS_THRESHOLD')
            ){
                $this->PATTERN = "OPENING_MARUBOZU";
            }

            // HAMMER_OR_HANGING_MAN
            if(
                ($this->lower_wick > $this->body * config('candlestick.HAMMER_LONGER_WICK_MULTIPLIER')) && 
                ($this->upper_wick < config('candlestick.HAMMER_SHORTER_WICK_THRESHOLD'))
            ){
                $this->PATTERN = "HAMMER_OR_HANGING_MAN";
            }

            // INVERTED_HAMMER_OR_SHOOTING_STAR
            if(
                ($this->upper_wick > $this->body * config('candlestick.HAMMER_LONGER_WICK_MULTIPLIER')) && 
                ($this->lower_wick < config('candlestick.HAMMER_SHORTER_WICK_THRESHOLD'))
            ){
                $this->PATTERN = "INVERTED_HAMMER_OR_SHOOTING_STAR";
            }

            // DRAGONFLY_DOJI
            if(
                ($this->lower_wick > config('candlestick.DOJI_WICK_MULTIPLIER') * $this->body) && 
                ($this->upper_wick < config('candlestick.DOJI_SHORTER_WICK_THRESHOLD'))
            ){
                $this->PATTERN = "DRAGONFLY_DOJI";
            }

            // GRAVESTONE_DOJI
            if(
                ($this->upper_wick > config('candlestick.DOJI_WICK_MULTIPLIER') * $this->body) && 
                ($this->lower_wick < config('candlestick.DOJI_SHORTER_WICK_THRESHOLD'))
            ){
                $this->PATTERN = "GRAVESTONE_DOJI";
            }

            // SPINNING_TOP
            if(
                ($this->body * config('candlestick.SPINNING_TOP_WICKS_MULTIPLIER') < (100 - $this->body)) && 
                abs($this->upper_wick - $this->lower_wick) < config('candlestick.SPINNING_TOP_WICKS_DIFFERENCE_THRESHOLD')
            ){
                $this->PATTERN = "SPINNING_TOP";
            }


        }

    }
 ?>