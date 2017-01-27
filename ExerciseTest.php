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
          "name" => "aaa.txt",
          "delim" => " ",
          "order" => array( 0, 1, 2, 3, 4 )
        );
        $this->assertEquals(true, $this->object->isFileValid($file1));
        $file2 = array(
          "name" => "bbb.txt",
          "order" => array( 0, 1, 2, 3, 4 )
        );
        $this->assertEquals(false, $this->object->isFileValid($file2));
    }


    /*
     * Test isPersonValid()
     */
    public function testIsPersonValid() {
        //. Assert for  
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
/*
    public function testReadNormalizedMember() {
        //. Assert for space.txt 
        $this->assertEquals(8, $this->object->readNormalizedMember(3, 5));
    }
*/
 
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
        $people0 = array(
          array("name"=>"Kei Kimura","gender"=>"Male","birthdate"=>strtotime("11/6/1968"),"color"=>"Blue"),
          array("name"=>"Shuzo Matsuoka","gender"=>"Male","birthdate"=>strtotime("11/6/1967"),"color"=>"Red"),
          array("name"=>"Mao Asada","gender"=>"Female","birthdate"=>strtotime("9/25/1990"),"color"=>"Blue"),
          array("name"=>"Marin Honda","gender"=>"Female","birthdate"=>strtotime("8/21/2001"),"color"=>"Red")
        );
        $people1 = array(
          array("name"=>"Kei Kimura","gender"=>"Male","birthdate"=>strtotime("11/6/1968"),"color"=>"Blue"),
          array("name"=>"Mao Asada","gender"=>"Female","birthdate"=>strtotime("9/25/1990"),"color"=>"Blue"),
          array("name"=>"Marin Honda","gender"=>"Female","birthdate"=>strtotime("8/21/2001"),"color"=>"Red"),
          array("name"=>"Shuzo Matsuoka","gender"=>"Male","birthdate"=>strtotime("11/6/1967"),"color"=>"Red")
        );
        $people2 = array(
          array("name"=>"Mao Asada","gender"=>"Female","birthdate"=>strtotime("9/25/1990"),"color"=>"Blue"),
          array("name"=>"Marin Honda","gender"=>"Female","birthdate"=>strtotime("8/21/2001"),"color"=>"Red"),
          array("name"=>"Kei Kimura","gender"=>"Male","birthdate"=>strtotime("11/6/1968"),"color"=>"Blue"),
          array("name"=>"Shuzo Matsuoka","gender"=>"Male","birthdate"=>strtotime("11/6/1967"),"color"=>"Red")
        );
        $people3 = array(
          array("name"=>"Marin Honda","gender"=>"Female","birthdate"=>strtotime("8/21/2001"),"color"=>"Red"),
          array("name"=>"Mao Asada","gender"=>"Female","birthdate"=>strtotime("9/25/1990"),"color"=>"Blue"),
          array("name"=>"Kei Kimura","gender"=>"Male","birthdate"=>strtotime("11/6/1968"),"color"=>"Blue"),
          array("name"=>"Shuzo Matsuoka","gender"=>"Male","birthdate"=>strtotime("11/6/1967"),"color"=>"Red")
        );
        $people4 = array(
          array("name"=>"Kei Kimura","gender"=>"Male","birthdate"=>strtotime("11/6/1968"),"color"=>"Blue"),
          array("name"=>"Mao Asada","gender"=>"Female","birthdate"=>strtotime("9/25/1990"),"color"=>"Blue"),
          array("name"=>"Shuzo Matsuoka","gender"=>"Male","birthdate"=>strtotime("11/6/1967"),"color"=>"Red"),
          array("name"=>"Marin Honda","gender"=>"Female","birthdate"=>strtotime("8/21/2001"),"color"=>"Red")
        );
        $this->assertEquals($people1, $this->object->sortBy($people0,"name"));
        $this->assertEquals($people2, $this->object->sortBy($people0,"gender"));
        $this->assertEquals($people3, $this->object->sortBy($people0,"birthdate",false));
        $this->assertEquals($people4, $this->object->sortBy($people0,"color"));
    }
 
}

