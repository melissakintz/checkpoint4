<?php


namespace App\Service;


class Extractor
{

    public function toArray(string $links): array
    {
        return explode(',', $links);
    }

    public function extractYoutube(string $links): array
    {
        $liens = $this->toArray($links);

        $ytIds = [];
        foreach($liens as $link){
            $array = explode('v=', $link);
            $id = explode('&', $array[1]);
            $ytIds[] = $id[0];
        }

        return $ytIds;
    }
}
