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

            $email = $_POST['email'];
            $faculty = $_POST['faculty'];
            $department = $_POST['department'];
            $courseNum = $_POST['courseNum'];

            if($courseNum=="" || $department=="" || $faculty=="" || $email==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (professor_exists($email, $courseNum, $DB))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Same Course Already Exists");
                    history.go(-1);
                    </script>');
                exit;
            }
            
            $DB->exec("INSERT INTO Professor VALUES ('$email', '$faculty', '$department', '$courseNum');");

            $DB = null;
            echo ('<script language="javascript"> 
            alert("Course Added!");
            window.location.href="sysop_manual_add.html";
            </script>');
            exit;


            function professor_exists($email, $courseNum, $DB) {
                $checkit = $DB->query( "SELECT * FROM Professor WHERE professor='$email' AND course='$courseNum';" );
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
