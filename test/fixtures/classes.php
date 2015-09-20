<?php

use entitiez\Entity;
use entitiez\Sanitizer;
use entitiez\Validator;

/**
 * ENTITIES
 */
class Person extends Entity {

   protected $name;
   protected $age;

   public function __construct($name = null, $age = null) {
      parent::__construct();
      $this->name = $name;
      $this->age = $age;
   }

   public function getName() {
      return $this->name;
   }

   public function setName($name) {
      $this->name = $name;
   }

   public function getAge() {
      return $this->age;
   }

   public function setAge($age) {
      $this->age = $age;
   }
}

class LocalizedPerson extends Person {

   private $address;

   public function __construct($name, $age, $address) {
      parent::__construct($name, $age);
      $this->address = $address;
   }

   public function getAddress() {
      return $this->address;
   }

   public function setAddress($address) {
      $this->address = $address;
   }
}

class NoGetters extends Entity {

   private $name;

   public function __construct($name) {
      $this->name = $name;
   }
}

class Family extends Entity {

   private $father;
   private $mother;

   public function getFather() {
      return $this->father;
   }

   public function setFather(Person $father) {
      $this->father = $father;
   }

   public function getMother() {
      return $this->mother;
   }

   public function setMother(Person $mother) {
      $this->mother = $mother;
   }
}

/**
 * SANITIZERS ===
 */
class PersonSanitizer extends Sanitizer {

   public function sanitize(Entity $entity) {
      
   }
}

/**
 * VALIDATORS ===
 */
class PersonValidator extends Validator {

   public function validate(Entity $person) {
      extract($person->export());
      return $name . "-" . $age;
   }
}

class LocalizedPersonValidator extends Validator {

   public function validate(Entity $localizedPerson) {
      extract($localizedPerson->export());
      return $name . "-" . $age . "-" . $address;
   }
}

class FamilyValidator extends Validator {

   public function validate(Entity $family) {
      extract($family->export());
      return $father["name"] . "-" . $mother["name"];
   }
}