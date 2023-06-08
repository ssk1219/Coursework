<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->


<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="scroll_table.css">
    </head>

    <body>
        <h1>
            TA Management
        </h1>
        <p>
            This area can only be accessed by the professors, teaching assistants, system operators and TA administrators.<br>
            Following functionalities are available:
            <ul>
                <li>Select Course</li>
                  <ul>
                    <li>Office Hours and Responsibilities</li>
                    <li>TA Wish-List</li>
                  </ul>
                </li>
              </ul>
        </p>
        
        <?php
            $DB = new SQLite3("../comp307.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }
            echo'
            <h2>List of Courses</h2>
            <p>Courses are ordered by the course number, year and term.<p>

            <table style="display: block;">
            <thead>
              <tr>
                <td style="position: sticky; top: 0; background-color: LightCoral;">First Name</td>
                <td style="position: sticky; top: 0; background-color: LightCoral;">Last Name</td>
                <td style="position: sticky; top: 0; background-color: LightCoral;">Year</td>
                <td style="position: sticky; top: 0; background-color: LightCoral;">Course Name</td>
              </tr>
            </thead>
            <tbody>
            ';

            $resultr = $DB->query("SELECT * FROM 'Course' ORDER BY courseNumber, year, term;");
            while($row = $resultr->fetchArray(SQLITE3_ASSOC)){         
                $courseNumber = $row['courseNumber'];                
                $term = $row['term'];
                $year = $row['year'];                
                $courseName = $row['courseName'];

                echo"<tr>";
                echo"<td>$courseNumber</td>";
                echo"<td>$term</td>";
                echo"<td>$year</td>";
                echo"<td>$courseName</td>";
                echo"</tr>";

                $DB=null;
            }

            echo'
            </tbody>
            </table>
            ';       
        ?> 

        <form action="TAManage_selected_course.php" method="post">
            <h2>
                Select Course
            </h2>
            <h4>
                Enter Course number, term and year.
            </h4>
            <p>
                Course Number: <input type="text" name="courseNum" placeholder='COMP 307'><br>
                Term: <input type="text" name="term" placeholder='Winter'><br>
                Year: <input type="text" name="year" placeholder='2022'><br>                
            </p>
            <input type="submit" value="Submit">
        </form>
    </body>
</html>