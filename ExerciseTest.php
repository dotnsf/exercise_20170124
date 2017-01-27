<?php
require_once 'Exercise.php';
class ExerciseTest extends PHPUnit_Framework_TestCase {
    /* 
     * @var Exercise 
     */
    protected $object;
 
    /* 
     * setUp 
     */
    protected function setUp() { 
        //. Target object 
        $this->object = new Exercise();
    }
 
    /*
     * Test isFileValid()
     */
    public function testIsFileValid() {
        $file1 = array(
          "name" => "space.txt",
          "delim" => " ",
          "order" => array( 0, 1, 3, 4, 5 )
        );
        $this->assertEquals(true, $this->object->isFileValid($file1));
        $file2 = array(
          "name" => "pipe.txt",
          "delim" => " | ",
          "order" => array( 0, 1, 3, 5, 4 )
        );
        $this->assertEquals(true, $this->object->isFileValid($file2));
        $file3 = array(
          "name" => "comma.txt",
          "delim" => ", ",
          "order" => array( 0, 1, 2, 4, 3 )
        );
        $this->assertEquals(true, $this->object->isFileValid($file3));
    }


    /*
     * Test isPersonValid()
     */
    public function testIsPersonValid() {
        $person1 = array(
          "name" => "Firstname Secondname",
          "gender" => "Gender",
          "birthdate" => strtotime( "11/6/1968" ),
          "color" => "Blue"
        );
        $this->assertEquals(true, $this->object->isPersonValid($person1));
        $person2 = array(
          "name" => "Firstname Secondname",
          "gender" => "Gender",
          "color" => "Blue"
        );
        $this->assertEquals(false, $this->object->isPersonValid($person2));
    }


    /*
     * Test readNormalizedMember()
     */
    public function testReadNormalizedMember() {
        $member1expect = array(
          array("name"=>"Kournikova Anna","gender"=>"Female","birthdate"=>strtotime("6/3/1975"),"color"=>"Red"),
          array("name"=>"Hingis Martina","gender"=>"Female","birthdate"=>strtotime("4/2/1979"),"color"=>"Green"),
          array("name"=>"Seles Monica","gender"=>"Female","birthdate"=>strtotime("12/2/1973"),"color"=>"Black"),
        );
        $file1 = array( "name" => "space.txt", "delim" => " ", "order" => array( 0, 1, 3, 4, 5 ) );
        $member1result = $this->object->readNormalizedMember($file1);
        $this->assertEquals($member1expect, $member1result);

        $member2expect = array(
          array("name"=>"Smith Steve","gender"=>"Male","birthdate"=>strtotime("3/3/1985"),"color"=>"Red"),
          array("name"=>"Bonk Radek","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Green"),
          array("name"=>"Bouillon Francis","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Blue")
        );
        $file2 = array( "name" => "pipe.txt", "delim" => " | ", "order" => array( 0, 1, 3, 5, 4, ) );
        $member2result = $this->object->readNormalizedMember($file2);
        $this->assertEquals($member2expect, $member2result);

        $member3expect = array(
          array("name"=>"Abercrombie Neil","gender"=>"Male","birthdate"=>strtotime("2/13/1943"),"color"=>"Tan"),
          array("name"=>"Bishop Timothy","gender"=>"Male","birthdate"=>strtotime("4/23/1967"),"color"=>"Yellow"),
          array("name"=>"Kelly Sue","gender"=>"Female","birthdate"=>strtotime("7/12/1959"),"color"=>"Pink")
        );
        $file3 = array( "name" => "comma.txt", "delim" => ", ", "order" => array( 0, 1, 2, 4, 3 ) );
        $member3result = $this->object->readNormalizedMember($file3);
        $this->assertEquals($member3expect, $member3result);
    }
 
    /*
     * Test fullGenderWord()
     */
    public function testFullGenderWord() {
        //. Assert "Male" for "Male" 
        $this->assertEquals( "Male", $this->object->fullGenderWord( "Male" ));
        //. Assert "Female" for "Female" 
        $this->assertEquals( "Female", $this->object->fullGenderWord( "Female" ));
        //. Assert "Male" for "M" 
        $this->assertEquals( "Male", $this->object->fullGenderWord( "M" ));
        //. Assert "Female" for "F" 
        $this->assertEquals( "Female", $this->object->fullGenderWord( "F" ));
    }
 
    /*
     * Test mystrtotime
     */
    public function testMystrtotime() {
        $time1 = strtotime( "02/28/2016" );
        $this->assertEquals($time1, $this->object->mystrtotime("2-28-2016"));
        $this->assertEquals($time1, $this->object->mystrtotime("2/28/2016"));
        $time2 = strtotime( "02/03/2016" );
        $this->assertEquals($time2, $this->object->mystrtotime("2-3-2016"));
        $this->assertEquals($time2, $this->object->mystrtotime("2/3/2016"));
    }
 
    /*
     * Test sortBy()
     */
    public function testSortBy() {
        $people = array(
          array("name"=>"Kournikova Anna","gender"=>"Female","birthdate"=>strtotime("6/3/1975"),"color"=>"Red"),
          array("name"=>"Hingis Martina","gender"=>"Female","birthdate"=>strtotime("4/2/1979"),"color"=>"Green"),
          array("name"=>"Seles Monica","gender"=>"Female","birthdate"=>strtotime("12/2/1973"),"color"=>"Black"),
          array("name"=>"Smith Steve","gender"=>"Male","birthdate"=>strtotime("3/3/1985"),"color"=>"Red"),
          array("name"=>"Bonk Radek","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Green"),
          array("name"=>"Bouillon Francis","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Blue"),
          array("name"=>"Abercrombie Neil","gender"=>"Male","birthdate"=>strtotime("2/13/1943"),"color"=>"Tan"),
          array("name"=>"Bishop Timothy","gender"=>"Male","birthdate"=>strtotime("4/23/1967"),"color"=>"Yellow"),
          array("name"=>"Kelly Sue","gender"=>"Female","birthdate"=>strtotime("7/12/1959"),"color"=>"Pink")
        );
        $output1 = array(
          array("name"=>"Hingis Martina","gender"=>"Female","birthdate"=>strtotime("4/2/1979"),"color"=>"Green"),
          array("name"=>"Kelly Sue","gender"=>"Female","birthdate"=>strtotime("7/12/1959"),"color"=>"Pink"),
          array("name"=>"Kournikova Anna","gender"=>"Female","birthdate"=>strtotime("6/3/1975"),"color"=>"Red"),
          array("name"=>"Seles Monica","gender"=>"Female","birthdate"=>strtotime("12/2/1973"),"color"=>"Black"),
          array("name"=>"Abercrombie Neil","gender"=>"Male","birthdate"=>strtotime("2/13/1943"),"color"=>"Tan"),
          array("name"=>"Bishop Timothy","gender"=>"Male","birthdate"=>strtotime("4/23/1967"),"color"=>"Yellow"),
          array("name"=>"Bonk Radek","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Green"),
          array("name"=>"Bouillon Francis","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Blue"),
          array("name"=>"Smith Steve","gender"=>"Male","birthdate"=>strtotime("3/3/1985"),"color"=>"Red")
        );
        $output2 = array(
          array("name"=>"Abercrombie Neil","gender"=>"Male","birthdate"=>strtotime("2/13/1943"),"color"=>"Tan"),
          array("name"=>"Kelly Sue","gender"=>"Female","birthdate"=>strtotime("7/12/1959"),"color"=>"Pink"),
          array("name"=>"Bishop Timothy","gender"=>"Male","birthdate"=>strtotime("4/23/1967"),"color"=>"Yellow"),
          array("name"=>"Seles Monica","gender"=>"Female","birthdate"=>strtotime("12/2/1973"),"color"=>"Black"),
          array("name"=>"Bonk Radek","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Green"),
          array("name"=>"Bouillon Francis","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Blue"),
          array("name"=>"Kournikova Anna","gender"=>"Female","birthdate"=>strtotime("6/3/1975"),"color"=>"Red"),
          array("name"=>"Hingis Martina","gender"=>"Female","birthdate"=>strtotime("4/2/1979"),"color"=>"Green"),
          array("name"=>"Smith Steve","gender"=>"Male","birthdate"=>strtotime("3/3/1985"),"color"=>"Red")
        );
        $output3 = array(
          array("name"=>"Smith Steve","gender"=>"Male","birthdate"=>strtotime("3/3/1985"),"color"=>"Red"),
          array("name"=>"Seles Monica","gender"=>"Female","birthdate"=>strtotime("12/2/1973"),"color"=>"Black"),
          array("name"=>"Kournikova Anna","gender"=>"Female","birthdate"=>strtotime("6/3/1975"),"color"=>"Red"),
          array("name"=>"Kelly Sue","gender"=>"Female","birthdate"=>strtotime("7/12/1959"),"color"=>"Pink"),
          array("name"=>"Hingis Martina","gender"=>"Female","birthdate"=>strtotime("4/2/1979"),"color"=>"Green"),
          array("name"=>"Bouillon Francis","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Blue"),
          array("name"=>"Bonk Radek","gender"=>"Male","birthdate"=>strtotime("6/3/1975"),"color"=>"Green"),
          array("name"=>"Bishop Timothy","gender"=>"Male","birthdate"=>strtotime("4/23/1967"),"color"=>"Yellow"),
          array("name"=>"Abercrombie Neil","gender"=>"Male","birthdate"=>strtotime("2/13/1943"),"color"=>"Tan")
        );

        $this->assertEquals($output1, $this->object->sortBy($this->object->sortBy($people,"name"),"gender"));
        $this->assertEquals($output2, $this->object->sortBy($this->object->sortBy($people,"name"),"birthdate"));
        $this->assertEquals($output3, $this->object->sortBy($people,"name",false));
    }
 
}

