<?php

namespace App\Exceptions;

use Exception;

class ForbiddenException extends Exception
{

    /**
     * The error data
     */
    protected $data;

    /**
     * Sets the Exception data
     *
     * @param array $data Data
     *
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get the Exception data
     *
     * @return array
     */
    public function getData(string $key = null)
    {
        if ($key !== null) {
            return array_get($this->data, $key);
        }

        return $this->data;
    }

}
