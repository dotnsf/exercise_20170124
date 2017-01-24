# exercise_20170124

## Overview

PHP code which can be an answer for following exercise:

<pre>
GOAL:

In the language of your choice, parse the following set of three input files:

space:

Kournikova Anna F F 6-3-1975 Red
Hingis Martina M F 4-2-1979 Green
Seles Monica H F 12-2-1973 Black


pipe:

Smith | Steve | D | M | Red | 3-3-1985
Bonk | Radek | S | M | Green | 6-3-1975
Bouillon | Francis | G | M | Blue | 6-3-1975


comma:

Abercrombie, Neil, Male, Tan, 2/13/1943
Bishop, Timothy, Male, Yellow, 4/23/1967
Kelly, Sue, Female, Pink, 7/12/1959


and produce the following output:

Output 1:

Hingis Martina Female 4/2/1979 Green
Kelly Sue Female 7/12/1959 Pink
Kournikova Anna Female 6/3/1975 Red
Seles Monica Female 12/2/1973 Black
Abercrombie Neil Male 2/13/1943 Tan
Bishop Timothy Male 4/23/1967 Yellow
Bonk Radek Male 6/3/1975 Green
Bouillon Francis Male 6/3/1975 Blue
Smith Steve Male 3/3/1985 Red

Output 2:

Abercrombie Neil Male 2/13/1943 Tan
Kelly Sue Female 7/12/1959 Pink
Bishop Timothy Male 4/23/1967 Yellow
Seles Monica Female 12/2/1973 Black
Bonk Radek Male 6/3/1975 Green
Bouillon Francis Male 6/3/1975 Blue
Kournikova Anna Female 6/3/1975 Red
Hingis Martina Female 4/2/1979 Green
Smith Steve Male 3/3/1985 Red

Output 3:

Smith Steve Male 3/3/1985 Red
Seles Monica Female 12/2/1973 Black
Kournikova Anna Female 6/3/1975 Red
Kelly Sue Female 7/12/1959 Pink
Hingis Martina Female 4/2/1979 Green
Bouillon Francis Male 6/3/1975 Blue
Bonk Radek Male 6/3/1975 Green
Bishop Timothy Male 4/23/1967 Yellow
Abercrombie Neil Male 2/13/1943 Tan
</pre>

## How to Execute

* Install PHP(5.3+).

* Download 3 text files(space.txt, pipe.txt, and comma.txt) and garage.php, and save them in same folder.

* Execute garage.php ($php -f garage.php)

## License

This code is licensed under MIT.

## Author

K.Kimura @ IBM Japan.

