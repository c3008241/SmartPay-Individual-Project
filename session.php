<?php

// function checkSession ($path) {

//     //Expire the session if user is inactive for 30
//     //minutes or more.
//     $expireAfter = 1; //this value is in minutes

//     //Check the interval since "last action" session
//     if(isset($_SESSION['last_action'])){
        
//         //Figure out how many seconds have passed
//         //since the user was last active.
//         $secondsInactive = time() - $_SESSION['last_action'];
        
//         //Convert our minutes into seconds.
//         $expireAfterSeconds = $expireAfter * 10;
        
//         //Check to see if they have been inactive for too long.
//         if($secondsInactive >= $expireAfterSeconds){
//             //User has been inactive for too long.
//             //Kill their session.
//             session_unset();
//             session_destroy();
//             header("Location:".$path);//return to the login page
//         }
//     }
//     $_SESSION['last_action'] = time(); //this variable is set for the very first time upon login
//     $url=$_SERVER['REQUEST_URI'];//to obtain the current page
//     $timeOut = ($expireAfter*60)+1; //1 second after the max session allowed. 
//     header("Refresh: $timeOut; URL=$url"); //refresh the screen
// }






// function checkSession ($path) {

//     //Expire the session if user is inactive for 30
//     //minutes or more.
//     $expireAfter = 1; //this value is in minutes

//     //Check the interval since "last action" session
//     if(isset($_SESSION['last_action'])){
        
//         //Figure out how many seconds have passed
//         //since the user was last active.
//         $secondsInactive = time() - $_SESSION['last_action'];
        
        
//         //Convert our minutes into seconds.
//         $expireAfterSeconds = $expireAfter * 10;
        
//         //Check to see if they have been inactive for too long.
//         if($secondsInactive >= $expireAfterSeconds){
//             //User has been inactive for too long.
//             //Kill their session.

//             // prompt an alert of js to the user to continue the session. Then set $_SESSION['last_action'] to the current time.
//             // if the is no action, then destroy the session and redirect to the login page
//             $_SESSION['last_action'] = time(); //this variable is set for the very first time upon login


//             session_unset();
//             session_destroy();
//             header("Location:".$path);//return to the login page
//         }
//     }
//     $_SESSION['last_action'] = time(); //this variable is set for the very first time upon login
//     $url=$_SERVER['REQUEST_URI'];//to obtain the current page
//     $timeOut = ($expireAfter*60)+1; //1 second after the max session allowed. 
//     header("Refresh: $timeOut; URL=$url"); //refresh the screen
// }

// 
function checkSession ($path) {
    $expireAfter = 30; // in minutes

    if (isset($_SESSION['last_action'])) {
        $secondsInactive = time() - $_SESSION['last_action'];
        $expireAfterSeconds = $expireAfter * 60;

        if ($secondsInactive >= $expireAfterSeconds) {
            session_unset();
            session_destroy();
            header("Location:" . $path);
            exit();
        }
    }
    $_SESSION['last_action'] = time();
}

?>