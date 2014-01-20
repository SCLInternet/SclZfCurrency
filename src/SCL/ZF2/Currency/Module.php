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
use Zend\ModuleManager\Feature\HydratorProviderInterface;
use Zend\ModuleManager\Feature\FormElementProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    FormElementProviderInterface,
    HydratorProviderInterface,
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

    public function getFormElementConfig()
    {
        return [
            'factories' => [
                'SCL\ZF2\Currency\Form\Fieldset\TaxedPrice' => function ($fem) {
                    return new \SCL\ZF2\Currency\Form\Fieldset\TaxedPrice();
                }
            ],
        ];
    }

    public function getHydratorConfig()
    {
        return [
            'factories' => [
                'scl_currency.taxed_price_hydrator' => function ($hm) {
                    $sm = $hm->getServiceLocator();
                    $ms = $sm->get('SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy');

                    $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
                    $hydrator->addStrategy('amount', $ms);
                    $hydrator->addStrategy('tax', $ms);

                    return $hydrator;
                },
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                'scl_currency.config' => function ($sm) {
                    return $sm->get('Config')['scl_currency'];
                },

                'SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy' => function ($sm) {
                    return new \SCL\ZF2\Currency\Hydrator\Strategy\MoneyStrategy(
                        $sm->get('scl_currency.money_factory')
                    );
                },

                'SCL\ZF2\Currency\Hydrator\Strategy\TaxedPriceStrategy' => function ($sm) {
                    return new \SCL\ZF2\Currency\Hydrator\Strategy\TaxedPriceStrategy(
                        $sm->get('scl_currency.taxed_price_factory')
                    );
                },

                // Defaults

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

                // Configurable

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
