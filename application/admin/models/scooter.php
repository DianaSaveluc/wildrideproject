<?php
  require_once("/../../../classes/BD.php");
  require_once("/../../../config/config.php");
    
  class ModelScooter{
      private static $db;
      public function __construct(){
          self::$db = new DB(); 
      }
      public function addScooter($param){ 
           $sql = "INSERT INTO trotinete(denumire, caracteristici, pret_inchiriere, tip_adaugare, data_adaugare, id_punct_de_lucru)
                    VALUES('{$param['denumire']}','{$param['caracteristici']}','{$param['pret_inchiriere']}',2,NOW(),{$param['punct_de_lucru']})";   
           
           $result = self::$db->query($sql);  
           
           return $result;  
      }
      public function updateScooter($param){
           $sql = "UPDATE trotinete
                    SET denumire='{$param['denumire']}', caracteristici='{$param['caracteristici']}', pret_inchiriere='{$param['pret_inchiriere']}', id_punct_de_lucru={$param['punct_de_lucru']}
                    WHERE id={$param['id']}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function deleteScooter($id){
          $sql = "DELETE FROM trotinete
                    WHERE id = {$id}";   
           
           $result = self::$db->query($sql);  
           
           return $result;
      }
      public function addScooterImport($param){
           $sql = "INSERT INTO import_trotinete(nume_fisier, data_import, id_utilizator)
                    VALUES('{$param['fileName']}',NOW(),{$_COOKIE['user_id']})";   
           
           $result = self::$db->query($sql);
           
           return $result; 
      }
      public function importScooterList($param){
           $t = 0;
           for($i = 2; $i<=count($param['data'][key($param['data'])]); $i++){
                $sql = "INSERT INTO trotinete(denumire, caracteristici, pret_inchiriere, tip_adaugare, data_adaugare, id_punct_de_lucru)
                    VALUES('{$param['data'][chr(ord($param['import_data'][$t]))][$i]}','{$param['data'][chr(ord($param['import_data'][$t])+1)][$i]}','{$param['data'][chr(ord($param['import_data'][$t])+2)][$i]}',1,NOW(),{$param['punct_de_lucru']})";   
           
                $result = self::$db->query($sql);    
                $t = 0;
           }               
           
           return $result; 
      }
      public function deleteScooters($param){
          foreach($param['select'] as $item){
              $sql = "DELETE FROM trotinete
                    WHERE id = {$item}";   
           
              $result = self::$db->query($sql); 
          }           
           
           return $result;
      }
  }
?>
