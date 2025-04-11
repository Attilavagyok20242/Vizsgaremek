<?php

use PHPUnit\Framework\TestCase;

class asd extends TestCase{
    public function TestAddReturnCorrectSUM(){
       require "./src/function.php";
       $this->assertEquals(4,add(2,2));
    } 
}