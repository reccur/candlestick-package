# Candlestick

![Stars](https://img.shields.io/github/stars/reccur/candlestick-package)
![Forks](https://img.shields.io/github/forks/reccur/candlestick-package)

Candlestick is a laravel package that helps to analyze various patterns, structures and trends in candlesticks

- Use it with Facade or as a library

## Installing Candlestick

The recommended way to install Candlestick is through
[Composer](https://getcomposer.org/).

```bash
composer require reccur/candlestick
```
## License

Candlestick is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.

## Usage

### Single Candlestick
```bash
$candle = Candlestick::single([
    'date'   => '2022-01-02',
    'o'      => 300.00,
    'h'      => 300.00,
    'l'      => 292.00,
    'c'      => 292.10,
    'volume' => 15623,
]);

$candle->color();
// Output: RED

$candle->pattern();
// Output: OPENING_MARUBOZU
```
Or use laravel Method Chaining

```bash
$pattern = Candlestick::single([
    'date'   => '2022-01-03',
    'o'      => 1784.00,
    'h'      => 1785.00,
    'l'      => 1750.00,
    'c'      => 1777.00,
    'volume' => 120,
])->pattern();

// Output: HAMMER_OR_HANGING_MAN
```

Getters

| Getter | Method |
| ------ | ------ |
| Date | ->date() |
| Open | ->o() |
| High | ->h() |
| Low | ->l() |
| Close | ->c() |
| Volume | ->volume() |
| Color | ->color() |
| Upper Wick (%) | ->upper_wick() |
| Body (%) | ->body() |
| Lower Wick (%) | ->lower_wick() |
| Wicks (%) | ->wicks() |
| Pattern | ->pattern() |

### Dual Candlesticks

```bash
$candle1 = Candlestick::single([
    'date'   => '2022-01-31',
    'o'      => 508.00,
    'h'      => 508.00,
    'l'      => 491.00,
    'c'      => 502.00,
    'volume' => 25171,
]);

$candle2 = Candlestick::single([
    'date'   => '2022-02-01',
    'o'      => 500.00,
    'h'      => 527.00,
    'l'      => 491.00,
    'c'      => 520.00,
    'volume' => 75030,
]);
Candlestick::dual($candle1, $candle2)->pattern();

// Output: BULLISH_ENGULFING
```

### Triple Candlesticks

```bash
Candlestick::dual($candle1, $candle2, $candle3)->pattern();

// Output: THREE_BLACK_CROWS
```
# Candlestick

![Stars](https://img.shields.io/github/stars/reccur/candlestick-package)
![Forks](https://img.shields.io/github/forks/reccur/candlestick-package)

Candlestick is a laravel package that helps to analyze various patterns, structures and trends in candlesticks

- Use it with Facade or as a library

## Installing Candlestick

The recommended way to install Candlestick is through
[Composer](https://getcomposer.org/).

```bash
composer require reccur/candlestick
```
## License

Candlestick is made available under the MIT License (MIT). Please see [License File](LICENSE) for more information.

## Usage

### Single Candlestick
```bash
$candle = Candlestick::single([
    'date'   => '2022-01-02',
    'o'      => 300.00,
    'h'      => 300.00,
    'l'      => 292.00,
    'c'      => 292.10,
    'volume' => 15623,
]);

$candle->color();
// Output: RED

$candle->pattern();
// Output: OPENING_MARUBOZU
```
Or use laravel Method Chaining

```bash
$pattern = Candlestick::single([
    'date'   => '2022-01-03',
    'o'      => 1784.00,
    'h'      => 1785.00,
    'l'      => 1750.00,
    'c'      => 1777.00,
    'volume' => 120,
])->pattern();

// Output: HAMMER_OR_HANGING_MAN
```

Getters

| Getter | Method |
| ------ | ------ |
| Date | ->date() |
| Open | ->o() |
| High | ->h() |
| Low | ->l() |
| Close | ->c() |
| Volume | ->volume() |
| Color | ->color() |
| Upper Wick (%) | ->upper_wick() |
| Body (%) | ->body() |
| Lower Wick (%) | ->lower_wick() |
| Wicks (%) | ->wicks() |
| Pattern | ->pattern() |

### Dual Candlesticks

```bash
$candle1 = Candlestick::single([
    'date'   => '2022-01-31',
    'o'      => 508.00,
    'h'      => 508.00,
    'l'      => 491.00,
    'c'      => 502.00,
    'volume' => 25171,
]);

$candle2 = Candlestick::single([
    'date'   => '2022-02-01',
    'o'      => 500.00,
    'h'      => 527.00,
    'l'      => 491.00,
    'c'      => 520.00,
    'volume' => 75030,
]);
Candlestick::dual($candle1, $candle2)->pattern();

// Output: BULLISH_ENGULFING
```

### Triple Candlesticks

```bash
Candlestick::dual($candle1, $candle2, $candle3)->pattern();

// Output: THREE_BLACK_CROWS
```
