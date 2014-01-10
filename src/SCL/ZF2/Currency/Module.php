<?php

namespace SCL\ZF2\Currency;

use SCL\Currency\Config;
use SCL\Currency\CurrencyFactory;
use SCL\Currency\MoneyFactory;
use SCL\Currency\TaxedPriceFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__,
                ],
            ],
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../../../../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'scl_currency.config' => function ($sm) {
                    return $sm->get('Config')['scl_currency'];
                },

                'scl_currency.currency_factory.default' => function ($sm) {
                    $config = $sm->get('scl_currency.config');

                    return new CurrencyFactory(
                        Config::getDefaultConfig(),
                        $config['default_currency']
                    );
                },
                'scl_currency.money_factory.default' => function ($sm) {
                    return MoneyFactory::createDefaultInstance();
                },
                'scl_currency.taxed_price_factory.default' => function ($sm) {
                    return TaxedPriceFactory::createDefaultInstance();
                },

                'scl_currency.currency_factory' => function ($sm) {
                    return $sm->get($sm->get('scl_currency.config')['currency_factory']);
                },
                'scl_currency.money_factory' => function ($sm) {
                    return $sm->get($sm->get('scl_currency.config')['money_factory']);
                },
                'scl_currency.taxed_price_factory' => function ($sm) {
                    return $sm->get($sm->get('scl_currency.config')['taxed_price_factory']);
                },
            ],
        ];
    }
}
