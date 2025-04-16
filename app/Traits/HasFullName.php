<?php

namespace App\Traits;

trait HasFullName
{
    public function getFullNameAttribute(): string
    {
        $parts = [
            $this->first_name,
            $this->middle_name,
            $this->last_name,
            $this->extension_name,
        ];

        // Filter out null or empty values and join with space
        return implode(' ', array_filter($parts));
    }
}
