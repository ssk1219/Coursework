<!-- Aybala Bengi Canpolat
260909564 -->

<html>
    <body>
        <?php

        $DB = new SQLite3("../comp307.sqlite", SQLITE3_OPEN_READWRITE);

        if($DB->lastErrorCode() != 0){
            echo "ERROR: Database connection failed!";
            echo $DB->lastErrorMsg();
        }
        
        $courseNumber = $_POST['courses'];
        $semester = $_POST['semester'];
        $TAname = $_POST['TAs'];
        $rating = $_POST['rating'];
        $comment = $_POST['comments']; // Not required.


         // Check if all required fields are filled.
         if($courseNumber=="" || $semester=="" || $TAname=="" || $rating==""){
            echo ('<script language="javascript"> 
                alert("WARNING: Please select all required fields.");
                history.go(-1);
                </script>');
            exit;
        }


         // Update the Rating table
         $resultw = $DB->exec( "INSERT INTO Rating ('courseNumber', 'semester', 'TAname', 'rating', 'comment') 
         VALUES ('$courseNumber', '$semester', '$TAname', '$rating', '$comment');");

         // Close db connection
         $DB->close();
         echo ('<script language="javascript"> 
         alert("TA Rating Submitted!");
         </script>');



        //if ($_SESSION['type'] == $r['type']) {

            $link = 'https://www.cs.mcgill.ca/~acanpo/307Project/dashboard/dashboard.html';
            printf(' <a href="' .$link. '">
                        <button  class="ui-state-default ui-corner-all"  style="background-image:url(\'./images.jpg\'); height:52px; width:152px;">                 
                        Back to Dashboard</button>
                        </a> ');
                        //}

         exit;
?>



          <!-- Link to go back to dashboard -->
          <div class="back">
          <i class="fa fa-arrow-left" aria-hidden="true"></i>
          <a href="../dashboard/dashboard.html"> Back to Dashboard </a>
          </div>
</body>
</html>