<?php

namespace AvoRed\Framework\Database\Repository;

use AvoRed\Framework\Database\Contracts\ConfigurationModelInterface;
use AvoRed\Framework\Database\Models\Configuration;

class ConfigurationRepository implements ConfigurationModelInterface
{
    /**
     * Get value of a configuration by given code
     * @param string $code
     * @return string $value
     */
    public function getValueByCode($code)
    {
        $configuration = Configuration::whereCode($code)->first();

        if ($configuration === null) {
            return null;
        }

        return $configuration->value;
    }

    /**
     * Get model of a configuration by given code
     * @param string $code
     * @return string $value
     */
    public function getModelByCode($code)
    {
        $configuration = Configuration::whereCode($code)->first();

        if ($configuration === null) {
            return null;
        }

        return $configuration;
    }

    /**
     * create configuration by given data
     * @param array $data
     * @return string $value
     */
    public function create(array $data): Configuration
    {
        return Configuration::create($data);
    }
}
