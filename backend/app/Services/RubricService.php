<?php

namespace App\Services;

use App\Exceptions\RubricDoesntExistException;
use App\Models\Rubric;

class RubricService
{
    /**
     * @throws RubricDoesntExistException
     */
    public function checkExist(array $rubrics): void
    {
        foreach ($rubrics as $rubric_item) {
            if (Rubric::where('id', $rubric_item)->doesntExist()) {
                throw new RubricDoesntExistException();
            }
        }
    }
}
