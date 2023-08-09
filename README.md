# broker_binance

Broker for binance exchange

'

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

function OpenLimitLong(IBrokerService $broker, string $pair, string $amount, string $price){
    return $broker->OpenLimitLong($pair, $amount, $price);
}

OpenLimitLong($broker, 'BTCUSDT', '0.001', '20000');
print_r($broker->GetErrorList()->ReadLast());
?>

```
