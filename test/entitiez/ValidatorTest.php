<?php

use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase {

   /**
    * @var PersonValidator
    */
   private $personValidator = null;

   /**
    * @var LocalizedPersonValidator
    */
   private $localizedPersonValidator = null;

   /**
    * @var FamilyValidator
    */
   private $familyValidator = null;

   public function setUp() {
      $this->personValidator = new PersonValidator();
      $this->localizedPersonValidator = new LocalizedPersonValidator();
      $this->familyValidator = new FamilyValidator();
   }

   public function tearDown() {
      $this->personValidator = null;
      $this->localizedPersonValidator = null;
      $this->familyValidator = null;
   }

   public function testExportInsideValidateMethod_BaseClass() {
      $out = $this->personValidator->validate(new Person("fabs", 33));
      $this->assertEquals("fabs-33", $out);
   }

   public function testExportInsideValidateMethod_ChildClass() {
      $out = $this->localizedPersonValidator->validate(new LocalizedPerson("fabs", 33, "NYC"));
      $this->assertEquals("fabs-33-NYC", $out);
   }

   public function testExportInsideValidateMethod_ComposedClass() {
      $f = new Family();
      $f->setFather(new Person("Pa", 46));
      $f->setMother(new Person("Ma", 40));
      $out = $this->familyValidator->validate($f);
      $this->assertEquals("Pa-Ma", $out);
   }
}