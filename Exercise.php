<?php
class Exercise{
  function __construct(){
    //. you can remove this line if you set it in php.ini
    date_default_timezone_set( 'UTC' );
  }


  /*
   * Validate file array
   *  $file : array which has to own at least following keys 
        name => (string)"filename"
        delim => (string)"delimiter"
        order => array( index number of first name, lastname, gender, birthdate, color )
   */
  public function isFileValid( $file ){
    $b = false;

    $b = array_key_exists( "name", $file ) && is_string( $file["name"] )
      && array_key_exists( "delim", $file ) && is_string( $file["delim"] )
      && array_key_exists( "order", $file ) && is_array( $file["order"] );

    return $b;
  }


  /*
   * Validate if person is normalized array object
   *  $person : array which has to own at least following keys 
        "name" => (string)"Firstname Secondname"
        "gender" => (string)"Gender"
        "birthdate" => (time)"M/D/YYYY"
        "color" => (string)"Color"
   */
  public function isPersonValid( $person ){
    $b = false;

    $b = array_key_exists( "name", $person ) && is_string( $person["name"] )
      && array_key_exists( "gender", $person ) && is_string( $person["gender"] )
      && array_key_exists( "birthdate", $person ) && is_numeric( $person["birthdate"] )
      && array_key_exists( "color", $person ) && is_string( $person["color"] );

    return $b;
  }


  /*
   * Read all line from text file, and align them as normalized data.
   *  $file : array of 
        name => (string)"filename"
        delim => (string)"word delimiter for each line"
        order => (array)(index number of first name, lastname, gender, birthdate, and color) )
   */
  public function readNormalizedMember( $file ){
    //. normalized data collection
    $member = array();

    //. read each line from files, and normalized them.
    try{
      $fno = fopen( $file['name'], 'r' );
      if( $fno ){
        if( flock( $fno, LOCK_SH ) ){
          $order = $file['order'];
          $delim = $file['delim'];
          while( !feof( $fno ) ){
            $line = trim( fgets( $fno ) ); //. normalize line
            $words = explode( $delim, $line );
            if( count( $words ) > 4 ){
              //. normalized object
              $person = array(
                "name" => $words[$order[0]] . " " . $words[$order[1]],
                "gender" => $this->fullGenderWord( $words[$order[2]] ),
                "birthdate" => $this->mystrtotime( $words[$order[3]] ),
                "color" => $words[$order[4]]
              );
              if( $this->isPersonValid( $person ) ){
                array_push( $member, $person );
              }
            }
          }
          flock( $fno, LOCK_UN );
        }
        fclose( $fno );
      }
    }catch( Exception $e ){
      fputs( STDERR, $e );
    }

    return $member;
  }

  /*
   * Return full gender word( "M"->"Male", "F"->"Female" )
   *  $word => (string)( "M", "m", "F", "f", "Male", "male", "MALE", "Female", "female", "FEMALE" )
   */
  public function fullGenderWord( $word ){
    $gender = ucfirst( $word ); //. default behavior

    if( $word == "M" ){
      $gender = "Male";
    }else if( $word == "F" ){
      $gender = "Female";
    }
  
    return $gender;
  }


  /*
   * Normalized strtotime function for variety of date formats.
   *  $datestr => (string)"M-D-YYYY" or "M/D/YYYY"
   *    * in PHP, strtotime() function accepts "D-M-YYYY" or "M/D/YYYY" as date.
   */
  public function mystrtotime( $datestr ){
    //. Separate datestr to day, month, and year with "-"
    $tmp = explode( "-", $datestr );

    if( count( $tmp ) > 2 ){
      //. Reorganize 'M-D-YYYY' as 'M/D/YYYY' order.
      $datestr = $tmp[0] . "/" . $tmp[1] . "/" . $tmp[2];
    }

    return strtotime( $datestr );
  }


  /*
   * (Bubble) Sort people array with specific field.
   *  $array => (array)people
   *  $field => (string)"field name"
   *  $asc => (boolean)( false if sort order is descendance )
   */
  public function sortBy( $array, $field, $asc = true ){
    $n = count( $array );
    for( $i = 0; $i < $n - 1; $i ++ ){
      $idx = $i;
      for( $j = $i + 1; $j < $n; $j ++ ){
        //. Jugde whether if $array[$j] should be over $array[$idx].
        $b = $asc ? $array[$idx][$field] > $array[$j][$field] : $array[$idx][$field] < $array[$j][$field];
        if( $b ){
          $idx = $j;
        }
      }

      if( $idx != $i ){
        //. shift order
        $tmp = $array[$idx];
        for( $j = $idx; $j > $i; $j -- ){
          $array[$j] = $array[$j-1];
        }
        $array[$i] = $tmp;
      }
    }
  
    return $array;
  }


  /*
   * Output people array ( to console ).
   *  $people : (array)(normalized person)
   */
  public function outputPeople( $people ){
    $n = count( $people );
    for( $i = 0; $i < $n; $i ++ ){
      $person = $people[$i];
      print $person['name'] . " " . $person['gender'] . " " . date( 'n/j/Y', $person['birthdate'] ) . " " . $person['color'] . "\n";
    }
  }

}


//. array of target files which contains
//.  name => (string)"filename"
//.  delim => (string)"word delimiter for each line"
//.  order => (array)(index number of first name, lastname, gender, birthdate, and color)
$files = array(
  array( "name" => "space.txt", "delim" => " ", "order" => array( 0, 1, 3, 4, 5 ) ),
  array( "name" => "pipe.txt", "delim" => " \| ", "order" => array( 0, 1, 3, 5, 4, ) ),
  array( "name" => "comma.txt", "delim" => ", ", "order" => array( 0, 1, 2, 4, 3 ) )
);


$obj = new Exercise();
$people = array();

//. Read all people with normalized style from all files
for( $i = 0; $i < count( $files ); $i ++ ){
  $file = $files[$i];
  if( $obj->isFileValid( $file ) ){
    $member = $obj->readNormalizedMember( $file );
    $people = array_merge( $people, $member );
  }
}


//. Output 1 : Sort by name -> by gender
$output1 = $obj->sortBy( $obj->sortBy( $people, "name" ), "gender" );
print "\nOutput 1:\n\n";
$obj->outputPeople( $output1 );

//. Output 2 : Sort by name -> by birthdate
$output2 = $obj->sortBy( $obj->sortBy( $people, "name" ), "birthdate" );
print "\nOutput 2:\n\n";
$obj->outputPeople( $output2 );

//. Output 3 : Sort by name(descendance)
$output3 = $obj->sortBy( $people, "name", false );
print "\nOutput 3:\n\n";
$obj->outputPeople( $output3 );

?>

