<?php

namespace Functions;

class Geo
{
   public static function lineToLeaflet($value)
   {
      $formatted = str_replace(['LINESTRING(',')'], '', $value);
      $formatted = str_replace(',', ';', $formatted);
      $formatted = str_replace(' ', ', ', $formatted);
      $formatted = "[".str_replace(';', '], [', $formatted)."]";

      return $formatted;
   }

   public static function leafletToLine($value)
   {
      $formatted = str_replace("], [", ";", $value);
      $formatted = str_replace(["[", "]"], "", $formatted);
      $formatted = str_replace(", ", " ", $formatted);
      $formatted = str_replace(";", ",", $formatted);
      $formatted = "LINESTRING(".$formatted.")";

      return $formatted;
   }
}