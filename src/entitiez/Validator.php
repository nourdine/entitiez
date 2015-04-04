<?php

namespace entitiez;

use entitiez\Entity;

abstract class Validator {

   /**
    * @return nourdine\parcels\ValidationParcel
    */
   abstract public function validate(Entity $entity);
}