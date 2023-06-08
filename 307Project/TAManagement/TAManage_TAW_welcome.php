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
                echo $DB->lastErrorMsg();
            }

            $TAWtableName = $_POST['TAWtableName'];
            $courseNum = $_POST['courseNum'];
            $email = $_POST['email'];
            $password = $_POST['password'];


            if( $email=="" || $password == "" ){
                echo ('<script language="javascript"> 
                    alert("WARNING: Form Not Completed");
                    history.go(-1);
                    </script>');
                exit;
            }

            if (is_not_professor($email, 'userId', $DB, 'user_usertype'))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: You are not a professor!");
                    history.go(-1);
                    </script>');
                    
                exit;
            }

            if (password_wrong($email, $password, $DB, 'user'))
            {
                echo ('<script language="javascript"> 
                    alert("WARNING: Password Does Not Match");
                    history.go(-1);
                    </script>');
                    
                exit;
            }

            echo ('<script language="javascript"> if(!!window.performance && window.performance.navigation.type == 2)
            {
                window.location.reload();
            } </script>');

            echo'
            <h1>Your TA Wish List for '.$courseNum.'</h1>

            <p>
                To switch to another course, the you must exit to the dashboard and then enter that course\'s page.<br>
                <a href="TAManage_welcome.php">Click here to return.</a>
            </p>

            <table style="display: block;">
            <thead>
              <tr>
                <td style="position: sticky; top: 0; background-color: Thistle;">Term and Year</td>
                <td style="position: sticky; top: 0; background-color: Thistle;">Course Number</td>
                <td style="position: sticky; top: 0; background-color: Thistle;">Professor Name</td>
                <td style="position: sticky; top: 0; background-color: Thistle;">TA Name</td>
              </tr>
            </thead>
            <tbody>
            ';

            $resultr = $DB2->query("SELECT * FROM '$TAWtableName';");
            while($row = $resultr->fetchArray(SQLITE3_ASSOC)){         
                $termAndYear = $row['term_year_this_is_for'];                
                $courseNumber = $row['course_num'];
                $profName = $row['prof_name'];                
                $TAName = $row['TA_name'];

                echo"<tr>";
                echo"<td>$termAndYear</td>";
                echo"<td>$courseNumber</td>";
                echo"<td>$profName</td>";
                echo"<td>$TAName</td>";
                echo"</tr>";
            }

            echo'
            </tbody>
            </table>
            ';

            echo'
            <h2>Add or Delete Your Wish List</h2>

            <form action="TAManage_update_TAW.php" method="post">
                
                <h4>
                    Enter all information.
                    You do not need to enter the course name.
                </h4>
                <p>
                    Term and Year this is for: <input type="text" name="termAndYear"  placeholder="Winter 2023"><br>
                    Professor Name: <input type="text" name="profName" placeholder="Joseph Vybihal"><br>
                    TA Name: <input type="text" name="TAName" placeholder="Sean Kim"><br>
                    Add or Delete? 
                    <input type="radio" name="addOrDelete" value="Add">Add
                    <input type="radio" name="addOrDelete" value="Delete">Delete
                    
                </p>
                
                <input type="hidden" name="TAWtableName" value="'.$TAWtableName.'">
                <input type="hidden" name="courseNum" value="'.$courseNum.'">
                <input type="submit" value="Submit">
            </form>';


            $DB = null;
            $DB2 = null;


            exit;

            function is_not_professor($item_value, $item_type, $DB, $tableName) {
                $checkit = $DB->query( "SELECT * FROM '$tableName' WHERE $item_type= '$item_value' AND userTypeId=2;" );
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

            function password_wrong($email, $password, $DB, $tableName) {
                $checkit = $DB->query( "SELECT * FROM '$tableName' WHERE email= '$email' AND password='$password';" );
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


            function update_item($item_value, $item_type, $user_email, $DB, $OHRtableName) {
                if ($item_value==""){
                } else {
                    $DB->exec( "UPDATE '$OHRtableName' SET $item_type='$item_value' WHERE name='$user_email';" );
                }
            }

        ?>
    </body>
</html>
