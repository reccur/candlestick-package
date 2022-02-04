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
    'o'      => 1501.03,
    'h'      => 1511.12,
    'l'      => 1423.31,
    'c'      => 1454.21,
    'volume' => 15623,
]);
```

```bash
Candlestick::dual($candle, $candle2);
```
