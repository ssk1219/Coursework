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
            

            $fileAddress = $_POST['fileAddress'];

            if($fileAddress==""){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }


            $myfile=fopen("$fileAddress", "r") or die("Unable to read the file!");

            if($_POST['withHeader']=="yes"){
                $header=fgetcsv($myfile);
            }

            //Counter to pass information
            $countrows=0;

            while(($row=fgetcsv($myfile))!= FALSE) {
                $term_year=$row[0];
                $course_num=$row[1];
                $course_name=$row[2];
                $instructor_name=$row[3];

                $term_and_year=explode(" ", $term_year);
                $term = $term_and_year[0];
                $year = $term_and_year[1];

                $namename=explode(" ", $instructor_name);
                $firstNameForEmail = strtolower($namename[0]);

                //Count number of rows 
                $countrows +=1;

                //Default values
                $course_description_default = "$course_num($course_name) is a course provided by professor $instructor_name in $term_year";
                $instructor_email_default = "$firstNameForEmail@comp307.com";
                $faculty_default = "Science";
                $department_default="Computer Science";

                echo$instructor_email_default;
                //INSERT IN COURSE - IDENTIFY MATCHING TERM, YEAR and COURSE NUM
                $DB->exec("INSERT INTO Course VALUES ('$course_name', '$course_description_default', '$term', '$year', '$course_num', '$instructor_email_default');");

                //INSERT IN PROF - IDENTIFY BY MATCHING NAME AND COURSE NUM
                $DB->exec("INSERT INTO Professor VALUES ('$instructor_email_default', '$faculty_default', '$department_default', '$course_num');");
                
                $alert_message="$countrows of course(s) and professor(s) added!";    
            }

            $DB = null;

            echo ('<script language="javascript"> 
            alert("'.$alert_message.'");
            window.location.href="sysop_import_csv.html";
            </script>');
            exit;
            fclose($myfile);    







            /*
            FILE INPUT METHOD - DOES NOT WORK ON MIMI

            if(!isset($_FILES['file']) || $_FILES['file']['error'] == UPLOAD_ERR_NO_FILE) {
                echo "Error no file selected"; 
            } else {
                print_r($_FILES);
            }

            // Missing a lot of error checks
            if(isset($_FILES)){
                $file_content = file($_FILES['file']['tmp_name']);
                foreach($file_content as $row) {
                    $items = explode(",", trim($row));
                    $instructor_email = $items[0];
                    echo($instructor_email);
                    $faculty = $items[1];
                    $department = $items[2];
                    $course_number = $items[3];
            
                    $sql = $conn->prepare("INSERT INTO Professor (professor, faculty, department, course) VALUES (?, ?, ?, ?)");
                    $sql->bind_param('ssss', $instructor_email, $faculty, $department, $course_number);
                    //$result = $sql->execute();
                }
            }
            */
        ?>
    </body>
</html>
