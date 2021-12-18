<?php

namespace Core;

class Model extends Database{
   protected $table;
   protected $field;
   protected $result;

   public function get()
   {
      if ( !isset($this->stmt) ) {
         $this->query("SELECT * FROM $this->table");
      }
      $this->result = $this->resultSet();
      return $this->result;
   }

   public function first()
   {
      $this->result = $this->resultSingle();
      return $this->result;
   }

   public function select($params)
   {
      $this->query("SELECT $params FROM $this->table");
      return $this;
   }

   public function where($dbColumn, $inputColumn)
   {
      if ( empty($this->stmt) ) {
         $this->query("SELECT * FROM $this->table where $dbColumn = $inputColumn");
      } else {
         $query = $this->lastQuery . strval(" where $dbColumn = $inputColumn");
         $this->query($query);
      }
      return $this;
   }

   public function insert($params)
   {
      $cols = $this->field;
      $columns = ':'.implode(', :', $this->field);

      $this->query("INSERT INTO $this->table VALUES ($columns)");
      foreach ( $cols as $col ) {
         if ( isset($params[$col]) ) {
            $this->bind($col, $params[$col]);
         } else {
            $this->bind($col, '');
         }
      }

      $this->execute();
      
      return $this->rowCount();
   }

   public function update($colName, $colValue, $params)
   {
      $columns = "";
      $columnsKey = array_keys($params);
      $lastKey = end($columnsKey);

      foreach ( $params as $key => $value ) {
         if ( $value == trim($value) && strpos($value, ' ') )
            $value = "'".$value."'";
         if ( $key == $lastKey )
            $columns .= $key.'='.$value;
         else
            $columns .= $key.'='.$value.', ';
      }
      $this->query("UPDATE $this->table SET $columns WHERE $colName=$colValue");

      $this->execute();

      return $this->rowCount();
   }

   public function addGeoPoint($colName, $colValue, $target, $params)
   {
      $point = "'POINT(".$params['x']." ".$params['y'].")'";
      $this->query("UPDATE $this->table SET $target=GeomFromText($point) WHERE $colName=$colValue");

      $this->execute();

      return $this->rowCount();
   }

   public function addGeoLine($colName, $colValue, $target, $params)
   {
      // input rute = "y, x; y, x; y, x";
      $lineExample = 'LineString(1 1,2 2,3 3)';
      $line = str_replace(',', '', $params['line']);
      $line = str_replace(';', ',', $line);
      $line = "LineString(".$line.")";
      $this->query("UPDATE $this->table SET $target=GeomFromText($line) WHERE $colName=$colValue");

      $this->execute();

      return $this->rowCount();
   }

   public function delete($id)
   {
      $this->query("DELETE FROM $this->table WHERE id= $id");
      $this->execute();

      return $this->rowCount();
   }

}