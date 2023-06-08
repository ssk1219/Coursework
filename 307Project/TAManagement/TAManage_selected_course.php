<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="scroll_table.css">
    </head>
    <body>
        <?php

            $DB = new SQLite3("../comp307.sqlite");
            $DB2 = new SQLite3("TAManage.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            if($DB2->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB2->lastErrorMsg();
            }


            $courseNum = $_POST['courseNum'];
            $term = $_POST['term'];
            $year = $_POST['year'];
            $semester = "$term $year";

            
            if($courseNum=="" || $term=="" || $year==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }
            

            if (course_not_exists($courseNum, $term, $year, $DB))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Course Does Not Exist");
                    history.go(-1);
                    </script>');
                exit;
            }

            echo ('<script language="javascript"> if(!!window.performance && window.performance.navigation.type == 2)
            {
                window.location.reload();
            } </script>');

            $OHRtableName = "$semester $courseNum OHR";
            $TAWtableName = "$semester $courseNum TAW";   
            $DB2->exec("CREATE TABLE IF NOT EXISTS '$OHRtableName' ('name' varchar(256) NOT NULL, 'officeHours' varchar(256) NOT NULL, 'officeLocation' varchar(256) NOT NULL, 'duty' varchar(256) NOT NULL);");
            $DB2->exec("CREATE TABLE IF NOT EXISTS '$TAWtableName' ('term_year_this_is_for' varchar(256) NOT NULL, 'course_num' varchar(256) NOT NULL, 'prof_name' varchar(256) NOT NULL, 'TA_name' varchar(256) NOT NULL);");

            echo'
            <html>
            <body>
                <h1>
                    '.$semester.' '.$courseNum.' Course Page
                </h1>
                <p>
                    To switch to another course, the you must exit to the dashboard and then enter that course\'s page.<br>
                    <a href="TAManage_welcome.php">Click here to return.</a>
                </p>

                <button onclick="myFunction1()">Office Hours and Responsibilities</button>
                <button onclick="myFunction2()">TA Wish List</button>
                
                <div id="OHR" style="display: block">
                    <h2>
                        Office Hours and Responsibilities
                    </h2>
                    <p>
                        The office hours and responsibilities feature allows the professor and teaching assistant to define the office hours, office locations, and duties of each TA and professor. <br>
                        It has a bonus feature to export to spreadsheet, which can be shared with students on myCourses.
                    </p>             
            ';

            #Display TA Office Hours
            #This part relies on 'TA' table, updated by TA Admin and 'Professor' Table, updated by Sysop
            echo'
            <h2>Professor & TA Office Hours</h2>

            <table style="display: block;">
            <thead>
              <tr>
                <td style="position: sticky; top: 0; background-color: LightCyan;">Professor/TA [Email]</td>
                <td style="position: sticky; top: 0; background-color: LightCyan;">Office Hours</td>
                <td style="position: sticky; top: 0; background-color: LightCyan;">Office Location</td>
                <td style="position: sticky; top: 0; background-color: LightCyan;">Duty</td>
              </tr>
            </thead>
            <tbody>
            ';
            
            #Check if Prof is registered in OHR table. If not, make a default row.
            $importProf = $DB->query("SELECT * FROM Course WHERE courseNumber='$courseNum' AND term='$term' AND year='$year';");
            while($row = $importProf->fetchArray(SQLITE3_ASSOC)){         
                $email = $row['courseInstructor'];
                OH_update($email, $OHRtableName, $DB2);
            }            

            #Check if TA is registered in OHR table. If not, make a default row.
            $importTA = $DB->query("SELECT * FROM TA WHERE semester='$semester' AND course_assigned_to='$courseNum';");
            while($row = $importTA->fetchArray(SQLITE3_ASSOC)){         
                $email = $row['email'];
                OH_update($email, $OHRtableName, $DB2);
            }

            #Display Office Hours Table
            $TAOHR = $DB2->query("SELECT * FROM '$OHRtableName';");
            while($row = $TAOHR->fetchArray(SQLITE3_ASSOC)){         
                $name = $row['name'];                
                $officeHours = $row['officeHours'];
                $officeLocation = $row['officeLocation'];                
                $duty = $row['duty'];

                echo"<tr>";
                echo"<td>$name</td>";
                echo"<td>$officeHours</td>";
                echo"<td>$officeLocation</td>";
                echo"<td>$duty</td>";
                echo"</tr>";   
            }

            echo'
            </tbody>
            </table>
            ';   

            #Let Prof and TA Update their office hours
            echo'
            <h2>Update Your Office Hours</h2>

            <form action="TAManage_update_OHR.php" method="post">
                <h4>
                    Type your email
                </h4>
                <p>
                    User email: <input type="text" name="email" placeholder="avi@comp307.com"><br>
                </p>
                <h4>
                    Enter information you wish to change
                </h4>
                <p>
                    Office Hours: <input type="text" name="OHRTime"  placeholder="Mondays from 11:00 to 13:00"><br>
                    Office Location: <input type="text" name="OHRLocation" placeholder="ENGTR 1080"><br>
                    Duty: <input type="text" name="OHRDuty" placeholder="Grading Assignment 2 and Host OHs"><br>
                </p>
                    <input type="hidden" name="OHRtableName" value="'.$OHRtableName.'">
                <input type="submit" value="Submit">
            </form>
        </div>
            
        <div id="TAW" style="display: none">
            <h2>
                TA Wish-List
            </h2>
            <p>
                TA wish-list feature can only be accessed by the instructor.<br>
                The instructor can identify to the TA administrator which TAs they would like to have next semester. 
            </p>

            <h2>Update Your TA Wish-List - PROFESSOR ONLY</h2>

            <form action="TAManage_TAW_welcome.php" method="post">
                <h4>
                    Enter your email
                </h4>
                <p>
                    User email: <input type="text" name="email" placeholder="joseph@comp307.com"><br>
                </p>
                <h4>
                    Enter your password
                </h4>
                <p>
                    User password: <input type="password" name="password"><br>
                </p> 
                <input type="hidden" name="TAWtableName" value="'.$TAWtableName.'">
                <input type="hidden" name="courseNum" value="'.$courseNum.'">
                <input type="submit" value="Submit">
            </form>
            </div>
            ';



            echo'
            <script>
            function myFunction1() {
              var x1 = document.getElementById("OHR");
              x1.style.display = "none";
              var x2 = document.getElementById("TAW");
              x2.style.display = "none";
              x1.style.display = "block";
            }
            function myFunction2() {
              var x1 = document.getElementById("OHR");
              x1.style.display = "none";
              var x2 = document.getElementById("TAW");
              x2.style.display = "none";
              x2.style.display = "block";
            }

                
            </script>
            ';

            
            function course_not_exists($courseNum, $term, $year, $DB) {
                $checkit = $DB->query( "SELECT * FROM Course WHERE courseNumber='$courseNum' AND term='$term' AND year='$year';" );
                $rows = 0; //set row counter to 0
                while($row = $checkit->fetchArray()) {
                    $rows += 1; //+1 to the counter per row in result
                }
                if($rows==0) {
                    return true;
                } else {
                    return false;
                }
            }

            function OH_update($email, $OHRtableName, $DB2) {
                $checkit = $DB2->query( "SELECT * FROM '$OHRtableName' WHERE name='$email';" );
                $rows = 0; //set row counter to 0
                while($row = $checkit->fetchArray()) {
                    $rows += 1; //+1 to the counter per row in result
                }
                if($rows==0) {
                    $DB2->exec("INSERT INTO '$OHRtableName' VALUES ('$email', 'office hours TBD', 'office location TBD', 'duty TBD');");
                    return ;
                } else {
                    return ;
                }
            }

            $DB=null;
            $DB2=null;
        ?>
    </body>
</html>
