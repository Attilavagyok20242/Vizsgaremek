<?php
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function testSikeresBelepes()
    {
        require_once "./Testtest/tesztteszt.php"; // módosítsd, ha máshol van

        $valasz = FelhasznaloNevJelszo("Attila", "Attila11"); // létező user kell
        $this->assertEquals(200, $valasz);
    }

    public function testHibasJelszo()
    {
        require_once "./Testtest/tesztteszt.php";

        $valasz = FelhasznaloNevJelszo("Attila", "rosszJelszo");
        $this->assertEquals(403, $valasz);
    }

    public function testNemletezoFelhasznalo()
    {
        require_once "./Testtest/tesztteszt.php";

        $valasz = FelhasznaloNevJelszo("NincsIlyenUser", "barmi");
        $this->assertEquals(404, $valasz);
    }

    public function testUresAdatok()
    {
        require_once "./Testtest/tesztteszt.php";

        $valasz = FelhasznaloNevJelszo("", "");
        $this->assertEquals(400, $valasz);
    }
}
