<?php

namespace App\Support;

class EnquiryOptions
{
    public static function countryCodes(): array
    {
        return [
            ['code' => '+91', 'name' => 'India'],
            ['code' => '+1', 'name' => 'United States'],
            ['code' => '+44', 'name' => 'United Kingdom'],
            ['code' => '+971', 'name' => 'United Arab Emirates'],
            ['code' => '+65', 'name' => 'Singapore'],
            ['code' => '+61', 'name' => 'Australia'],
            ['code' => '+1', 'name' => 'Canada'],
            ['code' => '+49', 'name' => 'Germany'],
            ['code' => '+33', 'name' => 'France'],
            ['code' => '+31', 'name' => 'Netherlands'],
            ['code' => '+966', 'name' => 'Saudi Arabia'],
        ];
    }

    public static function supportedCountryCodes(): array
    {
        return array_values(array_unique(array_column(self::countryCodes(), 'code')));
    }

    public static function technologies(): array
    {
        return [
            'Laravel / PHP',
            'React / Frontend',
            'Node.js',
            'Flutter / Mobile',
            'Python / AI',
            'Full Stack',
            'Other',
        ];
    }

    public static function budgetTypes(): array
    {
        return [
            'Hourly Basis',
            'Dedicated Developer',
            'Full Project',
            'Need Custom Quote',
        ];
    }
}
