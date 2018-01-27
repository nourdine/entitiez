<?php

use PHPUnit\Framework\TestCase;

class EntityParcelTest extends TestCase {

   /**
    * @var entitiez\Entity 
    */
   private $person = null;

   /**
    * @var entitiez\Entity 
    */
   private $localizedPerson = null;

   /**
    * @var entitiez\Entity 
    */
   private $noGetEntity = null;

   /**
    * @var entitiez\Entity 
    */
   private $family = null;

   public function setUp() {
      $this->person = new Person("fabs", 35);
      $this->localizedPerson = new LocalizedPerson("fabs", 35, "Rue De La Roquette");
      $this->noGetEntity = new NoGetters("laurent");
      $family = new Family();
      $family->setFather(new Person("Pa", 50));
      $family->setMother(new Person("Ma", 48));
      $this->family = $family;
   }

   public function tearDown() {
      $this->person = null;
      $this->noGetSetEntity = null;
   }

   public function testExportNoPrefix() {
      $export = $this->person->export("");
      $this->assertEquals("fabs", $export["name"]);
      $this->assertEquals(35, $export["age"]);
   }

   public function testExportWithPrefix() {
      $export = $this->person->export(":");
      $this->assertEquals("fabs", $export[":name"]);
      $this->assertEquals(35, $export[":age"]);
   }

   public function testExportSubklass() {
      $export = $this->localizedPerson->export();
      $this->assertEquals("Rue De La Roquette", $export["address"]);
   }

   public function testExportNested() {
      $export = $this->family->export();
      $this->assertEquals("Pa", $export["father"]["name"]);
      $this->assertEquals("Ma", $export["mother"]["name"]);
   }

   /**
    * @expectedException RuntimeException
    */
   public function testExportAndNoGettersAvailable() {
      $export = $this->noGetEntity->export(":");
   }
}