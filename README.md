# broker_binance

Broker for binance exchange

### Install

```json
  "require": {
    "jaro/broker_binance": "dev-master"
  },
  "repositories": [
    {
      "url": "https://github.com/Sidha2/broker_binance.git",
      "type": "git"
    }
  ]
```

```bash
comoser update
```

### Use

```php
<?php
declare(strict_types=1);

use BrokerBinance\Enums\TradeType;
use BrokerBinance\Repositories\BrokerRepository;
use BrokerBinance\Services\BrokerService;
use BrokerBinance\Models\BrokerSettings;
use BrokerBinance\Interface\IBrokerService;

require __DIR__ . '../../../vendor/autoload.php';

$broker = new BrokerService(
    new BrokerRepository(
        new BrokerSettings(
            TradeType::SPOT,
            'apiKey',
            'apiSecret',
        )
    ));

function OpenLimitBuy(IBrokerService $broker, string $pair, string $amount, string $price){
    return $broker->OpenLimitBuy($pair, $amount, $price);
}

OpenLimitBuy($broker, 'BTCUSDT', '0.001', '20000');
print_r($broker->GetErrorList()->ReadLast());
?>

```
