<?php

session_start( ); // allows us to retrieve our key form the session

/* 

First encrypt the key passed by the form, then compare it to the already encrypted key we have stored inside our session variable

*/

if( md5( $_POST[ 'code' ] ) != $_SESSION[ 'key' ] ) {

       echo "NOOK";

} else {

       echo "OK";

}

?>