<!DOCTYPE html>

<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta charset="UTF-8">
        <link rel="stylesheet" href="admindash.css">
      
       
        <script type="text/javascript" src="admindash.js" async></script>
        <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js" async></script> -->
    </head>

    <body>
        <h1 class="head">TA Administration</h1>
                 <?php
                        ini_set('display_errors', 1);

                        $DB = new SQLite3("../comp307.sqlite"); 
                        
                        if($DB->lastErrorCode() != 0){
                            //         echo "Database connection succeed!";
                                       echo $DB->lastErrorMsg();
                        }
                    ?>

        <div class="tabs">
           
                <button class="tablinks" onclick="openTab(event, 'cohort')" id="defaultTab">Ta Cohort</button>
                <button class="tablinks" onclick="openTab(event, 'course')">Course List</button>
                <!-- <button class="tablinks" onclick="openTab(event, 'iono')">iono if we keep this</button> -->

                <div id="cohort" class="tabcontent">

                    <form method="POST" action="" id="TAsemform" >
                        <select id="semester" name ="semester" class="dropdown">
                            <option value="please"  selected disabled>Please select a Semester</option>
                        </select>
                    </form>

                    <div>
                        <?php if(isset($_POST['semester'])){
                            $semesterOption = $_POST["semester"];
                            $spellSem = $semesterOption;
                            if(strpos($semesterOption, 'W')){
                                $spellSem = "Winter ".substr($semesterOption, 1, 4);
                            }
                            else if(strpos($semesterOption, 'F')){
                                $spellSem = "Fall ".substr($semesterOption, 1, 4);
                            }
                            else{
                                $spellSem = "Summer ".substr($semesterOption, 1, 4);
                            }

                            echo '<h2 class="head"> You are viewing: ' .$spellSem. '</h2>';
                            
                            $statement = $DB->prepare("SELECT TA_name FROM TACohort WHERE term_year = :semesterOption");
                            $statement->bindValue(':semesterOption', $semesterOption);
                            $result = $statement->execute();

                            $firstRow = true; ?>
                            <div class="flexy">
                            <table class="nameTable" id="taTable">
                            <?php while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                if ($firstRow) {?>
                                    <thead><tr>
                                    <th>TAs</th>
                                    </tr></thead>
                                    <tbody>
                                    <?php  $firstRow = false;
                                } ?>

                            <tr>
                            <!-- <?php foreach ($row as $value) {?> -->
                                    <td><?php echo $row['TA_name'] ?></td>
                                <!-- <?php } ?> -->
                                </tr>
                        <?php }
                         ?>
                        </tbody>
                        </table></div>
                        </div>
                        <h3 class="head">Select a TA from the List</h3>
                        <div class="flexy" id="TAdrop">
                        
                        <form method="post" action="" id="TAselect" >
                            <select id="taList" name ="taList" class="dropdown">
                                <option value="please"  selected disabled>Choose TA from List</option>
                                <?php 
                                $statement->reset();
                                $statement = $DB->prepare("SELECT * FROM TACohort WHERE term_year = :semesterOption");
                                $statement->bindValue(':semesterOption', $semesterOption);
                                $result = $statement->execute();
                                while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                                   echo '<option value="' . $row['TA_name'] . '">' . $row['TA_name'] . '</option>';
                                } ?>
                            </select>
                        </form>

                        
                        </div>
                        <div class="flexy">
                    
                        <?php  }
                            if(isset($_POST['taList'])){
                                // $statement->reset();
                                $curTa = $_POST['taList'];
                                $stat2 = $DB->prepare("SELECT * FROM TACohort WHERE TA_name = :curTa");

                                $stat2->bindValue(":curTa", $curTa);
                                $res2 = $stat2->execute();

                                $firstRow = true;
                                ?>
                            <div class="flexy">
                            <table class="infoTable" id="taTable">
                            <?php while ($row = $res2->fetchArray(SQLITE3_ASSOC)) {
                                $prior = $row['priority'];
                                if($row['priority'] == 0){
                                    $prior = 'No';
                                }
                                else{
                                    $prior = 'Yes';
                                }

                                $degL = $row['grad_ugrad'];
                                if($row['grad_ugrad'] == "G"){
                                    $degL = "Graduate";
                                }
                                else{
                                    $degL = "Undergraduate";
                                }

                                $open = $row["open_to_other_courses"];
                                if($row["open_to_other_courses"] == 0){
                                    $open = 'No';
                                }
                                else{
                                    $open = 'Yes';
                                }
                                
                                if ($firstRow) {?>
                                    <thead><tr>
                                        <th>Ta Name</th> <!--Includes legal name-->
                                        <th>Student ID</th>
                                        <th>Semester</th>
                                        <th>Degree</th> <!--grad undergrad and degree-->
                                        <th>Supervisor</th>
                                        <th>Hours and Location</th>
                                        <th>Contact</th> <!--email and phone-->
                                        <th>Applied Courses</th> <!--Includes date applied and priority-->
                                        <th>Notes"</th>
                                       
                                    </tr></thead>
                                    <tbody>
                                    <?php  $firstRow = false;
                                } ?>

                            <tr>
                                <td><?php echo "".$row["TA_name"]."\n (".$row["legal_name"].")"?></td>
                                <td><?php echo $row["student_ID"]?></td>
                                <td><?php echo $row["term_year"]?></td>
                                <td><?php echo "".$degL.", ".$row["degree"]?></td>
                                <td><?php echo $row["supervisor_name"]?></td>
                                <td><?php echo "in: ".$row["location"]."\n available for: ".$row["hours"]." hours"?></td>
                                <td><?php echo 'E-mail: <a href="'.$row["email"].'">' .$row["email"]. '</a></br></br> Phone: ' .$row["phone"]?></td>
                                <td><?php echo '<bf>List of Courses desired:</bf> '.$row["courses_applied_for_list"].
                                '</br></br> <bf>Date applied:</bf> '.$row["date_applied"].'</br></br> Other Courses?'.
                                $open?></td>
                                <td><?php echo 'Any Notes on student: </br>'.$row['notes'].
                                '</br></br> <bf>Priority?</bf> '.$prior?></td>
                                </tr>
                        <?php } ?>
                        </tbody>
                        </table></div>

                        <div>
                            <?php 

                            while ($row = $res2->fetchArray(SQLITE3_ASSOC)) {
                                $courses = $row['courses_applied_for_list'];
                                if(strlen($row['courses_applied_for_list']) == 23){
                                    $courses = [ 
                                        0 => substr($row['courses_applied_for_list'], 0, 7),
                                        1 => substr($row['courses_applied_for_list'], 8, 7),
                                        2 => substr($row['courses_applied_for_list'], 16, 7),
                                    ];
                                }
                                else if(strlen($row['courses_applied_for_list']) == 15){
                                    $courses = [ 
                                        0 => substr($row['courses_applied_for_list'], 0, 7),
                                        1 => substr($row['courses_applied_for_list'], 8, 7),
                                    ];
                                }
                                else{
                                    $courses = [
                                        0 => $row['courses_applied_for_list']];
                                }
                            ?>
                            <form action="" name="checkers">
                                <fieldset>
                                    <!-- <div class="courseCollex"> -->
                                    <?php 
                                    foreach($courses as $value){
                                        echo '<input type="checkbox" name="applied_course[]" value="'.$value.'" >'
                                        .$value.'</br>';
                                    }
                                    ?>
                                    <button class="btn" form="checkers" type="button">Add TA Courses</button>
                                    <!-- </div> -->
                                    
                                    <!-- <input type="submit" onClick=''> -->
                                </fieldset>
                            </form>
                            <?php

                        }
                            ?>
                            </div>
                                
                                    

                                    <?php
                                }
                        ?>
                        </div>
                    
                    
                    
                </div>

                <div id="course" class="tabcontent">
                    <div class="sem_select">
                    </div>

                    <div id="courseTable" >
                    </div>
                </div>
                
        </div>
        <?php
                        $DB->close();
                        ?>
    </body>
</html>