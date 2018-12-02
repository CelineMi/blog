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
        $slug = trim(str_replace($toReplace, $replaced, $input));

        return $slug;
    }
}