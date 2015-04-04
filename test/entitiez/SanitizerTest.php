<?php

class SanitizerTest extends PHPUnit_Framework_TestCase {

   /**
    * @var PersonSanitizer
    */
   private $sanitizer = null;

   public function setUp() {
      $this->sanitizer = new PersonSanitizer();
   }

   public function tearDown() {
      $this->sanitizer = null;
   }

   public function testConvertEmptyStringToNull() {
      $this->assertNull($this->sanitizer->convertEmptyStringToNull(false));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull(null));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull("\n"));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull("\r"));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull("\t"));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull(""));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull(" "));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull("  "));
      $this->assertNull($this->sanitizer->convertEmptyStringToNull("   "));
      $this->assertEquals("x", $this->sanitizer->convertEmptyStringToNull("x"));
   }

   public function testConvertToIntIfNotEmpty() {
      $this->assertTrue(null === $this->sanitizer->convertToIntIfNotEmpty(""));
      $this->assertTrue(null === $this->sanitizer->convertToIntIfNotEmpty(" "));
      $this->assertTrue(1 === $this->sanitizer->convertToIntIfNotEmpty("1"));
      $this->assertTrue(0 === $this->sanitizer->convertToIntIfNotEmpty("nan"));
      $this->assertTrue(null === $this->sanitizer->convertToIntIfNotEmpty("-"));
   }

   public function testConvertToFloatIfNotEmpty() {
      $this->assertTrue(null === $this->sanitizer->convertToFloatIfNotEmpty(""));
      $this->assertTrue(null === $this->sanitizer->convertToFloatIfNotEmpty(" "));
      $this->assertTrue(1.3 === $this->sanitizer->convertToFloatIfNotEmpty("1.3"));
      $this->assertTrue(2.0 === $this->sanitizer->convertToFloatIfNotEmpty("2"));
      $this->assertTrue(0.0 === $this->sanitizer->convertToFloatIfNotEmpty("nan"));
      $this->assertTrue(null === $this->sanitizer->convertToFloatIfNotEmpty("-"));
   }

   public function testConvertToBooleanIfNotEmpty() {
      $this->assertTrue(null === $this->sanitizer->convertToBooleanIfNotEmpty(""));
      $this->assertTrue(null === $this->sanitizer->convertToBooleanIfNotEmpty(" "));
      $this->assertTrue(true === $this->sanitizer->convertToBooleanIfNotEmpty("true"));
      $this->assertTrue(false === $this->sanitizer->convertToBooleanIfNotEmpty("false"));
      $this->assertTrue(false === $this->sanitizer->convertToBooleanIfNotEmpty("nab"));
      $this->assertTrue(null === $this->sanitizer->convertToBooleanIfNotEmpty("-"));
   }
}