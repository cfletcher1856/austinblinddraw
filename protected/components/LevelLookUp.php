<?php

class LevelLookUp{
      const DIRECTOR = 1;
      const ADMIN  = 2;
      // For CGridView, CListView Purposes
      public static function getLabel( $level ){
          if($level == self::DIRECTOR)
             return 'Director';
          if($level == self::ADMIN)
             return 'Administrator';
          return false;
      }
      // for dropdown lists purposes
      public static function getLevelList(){
          return array(
                 self::DIRECTOR=>'Director',
                 self::ADMIN=>'Administrator');
    }
}
