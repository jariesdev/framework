<?php

namespace AvoRed\Framework\Database\Contracts;

use AvoRed\Framework\Database\Models\Language;
use Illuminate\Database\Eloquent\Collection;

interface LanguageModelInterface
{
    /**
     * Create Language Resource into a database
     * @param array $data
     * @return \AvoRed\Framework\Database\Models\Language $language
     */
    public function create(array $data) : Language;

    /**
     * find roles for the users
     * @return \Illuminate\Database\Eloquent\Collection $languages
     */
    public function all() : Collection;
}
