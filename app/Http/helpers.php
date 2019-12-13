<?php

// define Global Constant
// User Type
define('USER_TYPE_ADMIN', 1);
define('USER_TYPE_EDITOR', 2);
define('USER_TYPE_NORMAL', 3);

// Poste Town
define('POSTE_TOWN_NOT_OWNER', 0);

/* Inform Sale... In contracting */
define('SALE_INFORMING', 1);

// define Global Function
function getUserName($user) {
    if(isset($user) && !is_null($user)) {
        if(!empty($user->first_name)) {
            return $user->first_name.' '.$user->last_name;
        } else {
            return $user->last_name;
        }
    }
    return '';
}
