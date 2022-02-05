<?php

namespace Reccur\Candlestick\Models;

use Reccur\Candlestick\Models\Candle;
use Reccur\Candlestick\Models\DualCandleStickChart;
use Reccur\Candlestick\Models\TripleCandleStickChart;

class CandleStick{

    public function single($params){
        $candle = new Candle([
            'date'   => $params['date'] ?? '',
            'o'      => $params['o'] ?? '',
            'h'      => $params['h'] ?? '',
            'l'      => $params['l'] ?? '',
            'c'      => $params['c'] ?? '',
            'volume' => $params['volume'] ?? '',
        ]);
        return $candle;
    }

    public function dual($candle1, $candle2){
       return new DualCandleStickChart($candle1, $candle2);
    }

    public function triple($candle1, $candle2, $candle3){
       return new TripleCandleStickChart($candle1, $candle2, $candle3);
    }

}