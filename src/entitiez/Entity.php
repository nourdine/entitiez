<?php

namespace entitiez;

use \ReflectionClass;
use \ReflectionMethod;

abstract class Entity {

   protected $getters;

   protected function resolveCascade($o, $prefix) {
      if ($o instanceof Entity) {
         return $o->export($prefix);
      }
      return $o;
   }

   public function __construct() {
      $klass = new ReflectionClass(get_class($this));
      $allMethods = $klass->getMethods(ReflectionMethod::IS_PUBLIC);
      foreach ($allMethods as $m) {
         $methodName = $m->getName();
         if (substr($methodName, 0, 3) == 'get') {
            $this->getters[] = $methodName;
         }
      }
   }

   /**
    * Export the internal state of the object into an associative array using the available getters.
    * If a contained entity is in turn an Entity, it will be exported recursively.
    * 
    * @param string $prefix A prefix to apply to the keys of the exported array
    * @return array
    * @throws \RuntimeException
    */
   public function export($prefix = "") {
      if (is_array($this->getters)) {
         $export = array();
         foreach ($this->getters as $method) {
            $value = $this->{$method}();
            $value = $this->resolveCascade($value, $prefix);
            $export[$prefix . lcfirst(substr($method, 3))] = $value;
         }
         return $export;
      } else {
         throw new \RuntimeException("Export failed: no getter methods available in class " . get_class($this));
      }
   }
}