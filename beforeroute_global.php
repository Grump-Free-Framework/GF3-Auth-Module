<?php
//This will be called no matter what module is being loaded
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
