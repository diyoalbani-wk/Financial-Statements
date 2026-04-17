<?php

namespace App\Helpers;

class CategoryHelper
{
    public static function getIncomeCategories()
    {
        return [
            'Gaji' => 'Gaji',
            'Bonus' => 'Bonus',
            'Investasi' => 'Investasi',
            'Usaha' => 'Usaha',
            'Hadiah' => 'Hadiah',
            'Lainnya' => 'Lainnya'
        ];
    }

    public static function getOutcomeCategories()
    {
        return [
            'Makanan' => 'Makanan',
            'Transport' => 'Transport',
            'Tagihan' => 'Tagihan',
            'Belanja' => 'Belanja',
            'Kesehatan' => 'Kesehatan',
            'Hiburan' => 'Hiburan',
            'Pendidikan' => 'Pendidikan',
            'Lainnya' => 'Lainnya'
        ];
    }

    public static function getCategories($type)
    {
        switch ($type) {
            case 'income':
                return self::getIncomeCategories();
            case 'outcome':
                return self::getOutcomeCategories();
            default:
                return [];
        }
    }

    public static function isValidCategory($category, $type)
    {
        $categories = self::getCategories($type);
        return array_key_exists($category, $categories);
    }
}
