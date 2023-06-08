
function displayMore(){
    let ID = document.getElementById("studentID-div");
    let semester = document.getElementById("semester-div");
    let courses = document.getElementById("courses-div");

    let student = document.getElementById("student");
    let TA = document.getElementById("ta");
    let prof = document.getElementById("prof");

    if(student.checked || TA.checked){
        ID.style.display = "block";
        semester.style.display = "block";

    } else if(prof.checked){
        semester.style.display = "block";

    } else {
        ID.style.display = "none";
        semester.style.display = "none";
        courses.style.display = "none";

    }
}


function renderCourses(){
    let courses = document.getElementById("courses-div");
    let fall = document.getElementById("fall");
    let winter = document.getElementById("winter");

    if(fall.checked || winter.checked){
        courses.style.display = "block";
    } else {
        courses.style.display = "none";
    }

}

