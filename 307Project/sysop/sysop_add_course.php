<!-- Name: Sean Kim-->
<!-- Student ID: 260984342 -->

<html>
    <body>
        <?php

            $DB = new SQLite3("../comp307.sqlite");

            if($DB->lastErrorCode() != 0){
                echo "ERROR: Database connection failed!";
                echo $DB->lastErrorMsg();
            }

            $courseNum = $_POST['courseNum'];
            $term = $_POST['term'];
            $year = $_POST['year'];
            $courseName = $_POST['courseName'];
            $courseDesc = $_POST['courseDesc'];
            $email = $_POST['email'];

            if($courseNum=="" || $term=="" || $year=="" || $courseName=="" || $courseDesc=="" || $email==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (course_exists($courseNum, $term, $year, $DB))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Same Course Already Exists");
                    history.go(-1);
                    </script>');
                exit;
            }
            
            $DB->exec("INSERT INTO Course VALUES ('$courseName', '$courseDesc', '$term', '$year', '$courseNum', '$email');");

            $DB = null;
            echo ('<script language="javascript"> 
            alert("Course Added!");
            window.location.href="sysop_manual_add.html";
            </script>');
            exit;


            function course_exists($courseNum, $term, $year, $DB) {
                $checkit = $DB->query( "SELECT * FROM Course WHERE courseNumber='$courseNum' AND term='$term' AND year='$year';" );
                $rows = 0; //set row counter to 0
                while($row = $checkit->fetchArray()) {
                    $rows += 1; //+1 to the counter per row in result
                }
                if($rows!=0) {
                    return true;
                } else {
                    return false;
                }
            }


        ?>
    </body>
</html>
