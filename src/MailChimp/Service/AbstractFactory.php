<?php

namespace MailChimp\Service;

use RuntimeException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractFactory implements FactoryInterface
{
    /**
     * @var array
     */
    protected $options;

    /**
     * Gets options from configuration based on name.
     *
     * @param  ServiceLocatorInterface      $sl
     * @param  string                       $key
     * @param  null|string                  $name
     * @return \Zend\Stdlib\AbstractOptions
     * @throws \RuntimeException
     */
    public function getOptions(ServiceLocatorInterface $sl, $key)
    {
        if (is_null($this->options)) {
            $options = $sl->get('Configuration');
            $options = $options['mailchimp'];
            $options = isset($options[$key]) ? $options[$key] : null;

            if (null === $options) {
                throw new RuntimeException(
                    sprintf(
                        'Options could not be found in "mailchimp.%s".',
                        $key
                    )
                );
            }

            $this->options = $options;
        }


        return $this->options;
    }
}
