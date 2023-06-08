

//const semCDropDown = document.getElementById("semesterC");
const semDropDown = document.getElementById("semester");
const taTable = document.getElementById("TATable");
const taDrop = document.getElementById("taList");
//const courseTable = document.getElementById("courseTable");
const semesters = {
    W23: 'W2023',
    F22: 'F2022',
    S22: 'S2022',
    W22: 'W2022',
    F21: 'F2021',
    S21: 'S2021',
    W21: 'W2021',
    F20: 'F2020',
}


// for(index in semesters) {
//     semDropDown.options[semDropDown.options.length] = new Option(semesters[index], index);
// }

// $('#semester').selectpicker('refresh');
for (let key in semesters){
  let option = document.createElement("option");
  option.setAttribute('value', semesters[key]);
  let optionText = document.createTextNode(semesters[key]);
  option.appendChild(optionText);
  semDropDown.appendChild(option);
}

semDropDown.addEventListener("change", e => {
 // taTable.innerHTML = "TAs in: " + e.target.value;
  document.getElementById("TAsemform").submit();
})

taDrop.addEventListener("change", e => {
  document.getElementById("TAselect").submit();
})
// for (let key in semesters){
//   let optionC = document.createElement("option");
//   optionC.setAttribute('value', semesters[key]);
//   let optionTextC = document.createTextNode(semesters[key]);
//   optionC.appendChild(optionTextC);
//   semCDropDown.appendChild(optionC);
// }

// semCDropDown.addEventListener("change", f => {
//   courseTable.innerHTML = "Courses from: " + f.target.value;
// })




 
function openTab(evt, tabName) {
    // Declare all variables
    var i, tabcontent, tablinks;
  
    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
  
    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
  
    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  document.getElementById("defaultTab").click();

  