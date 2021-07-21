<?php


namespace App\Service;


class Extractor
{
    public function extractYoutube(string $links): string
    {
        $array = explode('=', $links);
        return $array[1];
    }
}
