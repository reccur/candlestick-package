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

$candle->pattern();
```

```bash
Candlestick::dual($candle, $candle2);
```
