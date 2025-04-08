<?php
use PHPUnit\Framework\TestCase;

class test extends TestCase
{
    public function testSikeresBelepes()
    {
        require_once "./testnevek/asd.php"; 

        $valasz = FelhasznaloNevJelszo("Attila", "Attila11");
        $this->assertEquals(200, $valasz);
    }

    public function testHibasJelszo()
    {
        require_once "./testnevek/asd.php";

        $valasz = FelhasznaloNevJelszo("Attila", "asd");
        $this->assertEquals(403, $valasz);
    }

    public function testNemletezoFelhasznalo()
    {
        require_once "./testnevek/asd.php";

        $valasz = FelhasznaloNevJelszo("NincsIlyenUser", "barmi");
        $this->assertEquals(404, $valasz);
    }

    public function testUresAdatok()
    {
        require_once "./testnevek/asd.php";

        $valasz = FelhasznaloNevJelszo("", "");
        $this->assertEquals(400, $valasz);
    }
}
