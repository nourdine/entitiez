<?php

namespace entitiez;

use entitiez\Entity;

/**
 * Provides a bunch of methods to sanitize HTTP input.
 * All the methods are meant to process strings as this is the 
 * only data type HTTP inputs are represented in the form of.
 */
abstract class Sanitizer {

   /**
    * Return null if the input string is empty or the UNCHANGED string itself otherwise.
    * 
    * @param string $str
    * @return null|string
    */
   public function convertEmptyStringToNull($str) {
      return (trim($str) === "") ? null : $str;
   }

   /**
    * Return null if the input string is invalid or the UNCHANGED string itself otherwise.
    * 
    * @param string $str
    * @param array $invalidValues An array of invalid values
    * @return null|string
    */
   public function convertInvalidStringToNull($str, array $invalidValues) {
      foreach ($invalidValues as $iv) {
         if (trim($str) === $iv) {
            return null;
         }
      }
      return $str;
   }

   /**
    * An empty string must NOT be converted to 0 when casted to int or float.
    * An empty string must just be a fucking null when it enters the numeric domain.
    * 
    * @param string $str
    * @param array $invalidValues A bunch of values that has to be considered null
    * @return int or null 
    */
   public function convertToIntIfNotEmpty($str, $invalidValues = array("-")) {
      $value = $this->convertEmptyStringToNull($str);
      $value = $this->convertInvalidStringToNull($value, $invalidValues);
      if ($value !== null) {
         return (int) $value;
      }
   }

   /**
    * See above.
    * 
    * @return float or null
    */
   public function convertToFloatIfNotEmpty($str, $invalidValues = array("-")) {
      $value = $this->convertEmptyStringToNull($str);
      $value = $this->convertInvalidStringToNull($value, $invalidValues);
      if ($value !== null) {
         return (float) $value;
      }
   }

   /**
    * See above.
    * 
    * @return boolean or null
    */
   public function convertToBooleanIfNotEmpty($str, $invalidValues = array("-")) {
      $value = $this->convertEmptyStringToNull($str);
      $value = $this->convertInvalidStringToNull($value, $invalidValues);
      if ($value !== null) {
         if ($value === "true") {
            return true;
         }
         return false;
      }
   }

   /**
    * Escape all language-specific symbols (html, SQL) 
    * and convert the input into a utf-8 safe-to-use string.
    * 
    * @param string $str
    * @return string
    */
   public function purifyString($str) {
      $str = (string) $str;
      $str = iconv(mb_detect_encoding($str), 'UTF-8', $str); // convert to utf-8
      $str = trim($str);
      $str = htmlspecialchars($str);
      return $str;
   }

   /**
    * @return core\entity\Entity 
    */
   abstract public function sanitize(Entity $entity);
}