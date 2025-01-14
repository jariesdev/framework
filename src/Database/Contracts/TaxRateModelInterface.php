<?php

namespace AvoRed\Framework\Database\Contracts;

use AvoRed\Framework\Database\Models\TaxRate;
use Illuminate\Database\Eloquent\Collection;

interface TaxRateModelInterface
{
    /**
     * Create TaxRate Resource into a database
     * @param array $data
     * @return \AvoRed\Framework\Database\Models\TaxRate $taxGroup
     */
    public function create(array $data) : TaxRate;

    /**
     * find roles for the users
     * @return \Illuminate\Database\Eloquent\Collection $taxGroups
     */
    public function all() : Collection;
}
