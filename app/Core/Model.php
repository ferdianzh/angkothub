<?php

namespace Core;

class Model extends Database{
   protected $table;
   protected $field;
   protected $result;

   /**
    * Get all query result
    */
   public function get()
   {
      if ( !isset($this->stmt) ) {
         $this->query("SELECT * FROM $this->table");
      }
      $this->result = $this->resultSet();
      return $this->result;
   }

   /**
    * Get first query result
    */
   public function first()
   {
      $this->result = $this->resultSingle();
      return $this->result;
   }

   /**
    * Select a table column
    */
   public function select($params)
   {
      $this->query("SELECT $params FROM $this->table");
      return $this;
   }

   /**
    * Add condition to query
    */
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

   /**
    * Insert new data to database
    */
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

   /**
    * Update value of a data
    */
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

   /**
    * Add point value to a data
    */
   public function addGeoPoint($colName, $colValue, $target, $params)
   {
      $point = "'POINT(".$params['x']." ".$params['y'].")'";
      $this->query("UPDATE $this->table SET $target=GeomFromText($point) WHERE $colName=$colValue");

      $this->execute();

      return $this->rowCount();
   }

   /**
    * Add linestring value to a data
    */
   public function addGeoLine($colName, $colValue, $params)
   {
      // $inputExample = [-7.26811, 112.65676], [-7.27811, 112.66676];
      // $lineExample = 'LineString(1 1,2 2,3 3)';

      foreach ( $params as $paramKey => $paramVal ) {
         $line = "'".$paramVal."'";
         $this->query("UPDATE $this->table SET $paramKey=GeomFromText($line) WHERE $colName=$colValue");

         $this->execute();
      }

      return $this->rowCount();
   }

   /**
    * Delete a data from table
    */
   public function delete($id)
   {
      $this->query("DELETE FROM $this->table WHERE id= $id");
      $this->execute();

      return $this->rowCount();
   }

}