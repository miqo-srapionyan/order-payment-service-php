<?php

declare(strict_types=1);

namespace App\Models;

use Exception;

use function strtolower;
use function property_exists;

class Model {
    /**
     * Magic method to get a property value dynamically.
     *
     * @param string $name The property name to retrieve.
     * @return mixed The value of the property.
     * @throws Exception If the property does not exist.
     */
    public function __get(string $name)
    {
        $property = strtolower($name); // Convert name to lowercase if necessary

        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new Exception("Property '{$name}' not found.");
    }

    /**
     * Magic method to set a property value dynamically.
     *
     * @param string $name The property name to set.
     * @param mixed $value The value to assign to the property.
     * @throws Exception If the property does not exist.
     */
    public function __set(string $name, $value): void
    {
        $property = strtolower($name); // Convert name to lowercase if necessary

        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Property '{$name}' not found.");
        }
    }
}
