<?php


namespace App\Tests\Services;

use App\Service\Extractor;
use PHPUnit\Framework\TestCase;

class ExtractorTest extends TestCase
{
    public function testExtractor()
    {
        $extractor = new Extractor();
        //test for youtube
        $this->assertEquals(['qt_urUz42vI', 'yfYjEkaN-1s'], $extractor->extractYoutube('https://www.youtube.com/watch?v=qt_urUz42vI&ab_channel=MusicLab,https://www.youtube.com/watch?v=yfYjEkaN-1s&ab_channel=4KVideoNature-FocusMusic'));

        //test for spotify
        $this->assertEquals(['3Lt558KSXrSTLBr3EJ3BAe', '53nYJhuLN93D8WIDfJd4Rf'],$extractor->extractSpotify('https://open.spotify.com/track/3Lt558KSXrSTLBr3EJ3BAe?si=3a3c22f0d17f42fb,https://open.spotify.com/track/53nYJhuLN93D8WIDfJd4Rf?si=3cb4bf930dc54195'));
    }
}
