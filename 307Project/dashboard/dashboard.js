
window.onload = function()
{
    showContent();
    // displayRatingStats();
}

/**
 * Tells user how many ratings hav been submitted through the app
 */
function displayRatingStats()
{
    try{
        const req = new XMLHttpRequest();
        req.open("POST", "ratingStats.php", false);
        req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        req.send();
        let response = req.responseText;
        document.getElementById("ratingStats").innerHTML = response;
        
    }catch (exception)
    {
        alert("Request failed.");
    }
}


/**
 * Shows the dashboard
 */
function showContent()
{
    try{
        const request = new XMLHttpRequest();
        request.open("POST", "dashboard.php", false);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.send();
    
        if (request.status === 200) {

            let response = request.responseText;
            // document.getElementById("personalizedDashboard").innerHTML = response;


        //     let parser = new DOMParser();
        //     let xmlDoc = parser.parseFromString(syncRequest.responseText, "text/xml");
        //     let scripts = xmlDoc.getElementsByTagName("script");

        //     // login success
        //     if (scripts.length > 0) {
        //         document.body.innerHTML = syncRequest.responseText;
        //         let scripts = document.body.getElementsByTagName("script");
        //         eval(scripts[0].text); // execute the declaration code for our returned 
        //         // functions so that the browser knows they exist
        //         redirect(); // redirect to the user's dashboard
            } else {
                let errorDiv = document.getElementById("login-error");
                errorDiv.innerHTML = syncRequest.responseText;
            }
        
    } catch (exception) {
        alert("Request failed.");
    }
}


