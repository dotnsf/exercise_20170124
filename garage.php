<?php
//. you can remove this line if you set it in php.ini
date_default_timezone_set( 'UTC' );

//. array of 
//.  name       : filename
//.  delim      : word delimiter for each line
//.  order      : index number of first name, lastname, gender, birthdate, and color
$files = array(
  array( "name" => "space.txt", "delim" => " ", "order" => array( 0, 1, 3, 4, 5 ) ),
  array( "name" => "pipe.txt", "delim" => " \| ", "order" => array( 0, 1, 3, 5, 4, ) ),
  array( "name" => "comma.txt", "delim" => ", ", "order" => array( 0, 1, 2, 4, 3 ) )
);

//. normalized data collection
$people = array();

//. read all lines from all files, and normalized them.
for( $i = 0; $i < count( $files ); $i ++ ){
  $file = $files[$i];
  try{
    $fno = fopen( $file['name'], 'r' );
    if( $fno ){
      if( flock( $fno, LOCK_SH ) ){
        $order = $file['order'];
        $delim = $file['delim'];
        while( !feof( $fno ) ){
          $line = trim( fgets( $fno ) ); //. normalize line
          $words = split( $delim, $line );
          if( count( $words ) > 4 ){
            //. normalized object
            $person = array(
              "name" => $words[$order[0]] . " " . $words[$order[1]],
              "gender" => fullGenderWord( $words[$order[2]] ),
              "birthdate" => mystrtotime( $words[$order[3]] ),
              "color" => $words[$order[4]]
            );
            array_push( $people, $person );
          }
        }
        flock( $fno, LOCK_UN );
      }
      fclose( $fno );
    }
  }catch( Exception $e ){
    fputs( STDERR, $e );
  }
}

//. Output 1 : Sort by name -> by gender
$output1 = sortBy( sortBy( $people, "name" ), "gender" );
print "\nOutput 1:\n\n";
outputPeople( $output1 );

//. Output 2 : Sort by name -> by birthdate
$output2 = sortBy( sortBy( $people, "name" ), "birthdate" );
print "\nOutput 2:\n\n";
outputPeople( $output2 );

//. Output 3 : Sort by name(descendance)
$output3 = sortBy( $people, "name", false );
print "\nOutput 3:\n\n";
outputPeople( $output3 );

exit( 0 );



/*
 * Functions
 */

/*
 * Return full gender word( "M"->"Male", "F"->"Female" )
 */
function fullGenderWord( $word ){
  $gender = $word;

  if( $word == "M" ){
    $gender = "Male";
  }else if( $word == "F" ){
    $gender = "Female";
  }
  
  return $gender;
}

/*
 * Normalized strtotime function for variety of date formats.
 */
function mystrtotime( $datestr ){
  //. Separate datestr to day, month, and year
  $tmp = split( "-", $datestr );
  if( count( $tmp ) < 3 ){
    $tmp = split( "/", $datestr );
  }

  if( count( $tmp ) > 2 ){
    //. Reorganize 'month-day-year'.
    $datestr = $tmp[1] . "-" . $tmp[0] . "-" . $tmp[2];
  }

  return strtotime( $datestr );
}


/*
 * (Bubble) Sort people array with specific field.
 */
function sortBy( $array, $field, $asc = true ){
  $n = count( $array );
  for( $i = 0; $i < $n - 1; $i ++ ){
    for( $j = $i + 1; $j < $n; $j ++ ){
      //. Jugde whether if $array[$i] and $array[$j] need to be swapped.
      $b = $asc ? $array[$i][$field] > $array[$j][$field] : $array[$i][$field] < $array[$j][$field];
      if( $b ){
        //. Swap order.
        $tmp = $array[$i];
        $array[$i] = $array[$j];
        $array[$j] = $tmp;
      }
    }
  }

  return $array;
}

/*
 * Output people array ( to console ).
 */
function outputPeople( $array ){
  $n = count( $array );
  for( $i = 0; $i < $n; $i ++ ){
    $person = $array[$i];
    print $person['name'] . " " . $person['gender'] . " " . date( 'n/j/Y', $person['birthdate'] ) . " " . $person['color'] . "\n";
  }
}

?>

