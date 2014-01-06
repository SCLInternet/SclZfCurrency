<?php

namespace SCL\ZF2\Currency;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use SCL\Currency\CurrencyFactory;
use SCL\Currency\MoneyFactory;
use SCL\Currency\TaxedPriceFactory;

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
                    $config = $sm->get('Config');

                    return $config['scl_currency'];
                },
                'scl_currency.currency_factory.default' => function ($sm) {
                    return CurrencyFactory::createDefaultInstance();
                },
                'scl_currency.money_factory.default' => function ($sm) {
                    return MoneyFactory::createDefaultInstance();
                },
                'scl_currency.taxed_price_factory.default' => function ($sm) {
                    return TaxedPriceFactory::createDefaultInstance();
                },

                'scl_currency.currency_factory' => function ($sm) {
                    $config = $sm->get('scl_currency.config');

                    return $sm->get($config['scl_currency.currency_factory']);
                },
                'scl_currency.money_factory' => function ($sm) {
                    $config = $sm->get('scl_currency.config');

                    return $sm->get($config['scl_currency.money_factory']);
                },
                'scl_currency.taxed_price_factory' => function ($sm) {
                    $config = $sm->get('scl_currency.config');

                    return $sm->get($config['scl_currency.taxed_price_factory']);
                },
            ],
        ];
    }
}
