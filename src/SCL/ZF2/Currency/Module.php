<?php

namespace SCL\ZF2\Currency;

use SCL\Currency\Config;
use SCL\Currency\CurrencyFactory;
use SCL\Currency\MoneyFactory;
use SCL\Currency\Money\Formatter;
use SCL\Currency\Money\Formatter\AsciiContext;
use SCL\Currency\Money\Formatter\HtmlContext;
use SCL\Currency\TaxedPriceFactory;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use SCL\ZF2\Currency\View\Helper\FormatMoney;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
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

                'scl_currency.html_money_formatter.default' => function ($sm) {
                    return Formatter::createDefaultInstance(new HtmlContext());
                },
                'scl_currency.string_money_formatter.default' => function ($sm) {
                    return Formatter::createDefaultInstance(new AsciiContext());
                },

                'scl_currency.currency_factory' => function ($sm) {
                    return $this->getServiceModuleConfig($sm, 'currency_factory');
                },
                'scl_currency.money_factory' => function ($sm) {
                    return $this->getServiceModuleConfig($sm, 'money_factory');
                },
                'scl_currency.taxed_price_factory' => function ($sm) {
                    return $this->getServiceModuleConfig($sm, 'taxed_price_factory');
                },
                'scl_currency.html_money_formatter' => function ($sm) {
                    return $this->getServiceModuleConfig($sm, 'html_money_formatter');
                },
                'scl_currency.string_money_formatter' => function ($sm) {
                    return $this->getServiceModuleConfig($sm, 'string_money_formatter');
                },
            ],
        ];
    }

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'formatMoney' => function ($vhm) {
                    $sm = $vhm->getServiceLocator();

                    return new FormatMoney($sm->get('scl_currency.html_money_formatter'));
                },
            ],
        ];
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    private function getServiceModuleConfig(ServiceLocatorInterface $sm, $name)
    {
        return $sm->get($sm->get('scl_currency.config')[$name]);
    }
}
