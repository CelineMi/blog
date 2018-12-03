<?php
/**
 * Created by PhpStorm.
 * User: celine
 * Date: 02/12/18
 * Time: 17:00
 */

namespace App\Service;


class Slugify
{
    public function generate(string $input) :string
    {
        $toReplace = [['é', 'è', 'ê'],'à','ï', 'ô', 'ç', [' ', '.', ',', '!', ';', ':','@']];
        $replaced = [['e'], 'a', 'i', 'o', 'c', ['_']];
        $slug = preg_replace(',::.?\/!@#$%&*', '', $input);
        $slug = preg_replace(' ', '_', $input);
        $slug = preg_replace('èéê', 'e', $input);
        $slug = preg_replace('à', 'a', $input);
        $slug = preg_replace('ç', 'c', $input);
        $slug = preg_replace('ï', 'i', $input);
        $slug = preg_replace('ù', 'u', $input);
        $slug = trim($slug);


        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);



        return $slug;
    }
}