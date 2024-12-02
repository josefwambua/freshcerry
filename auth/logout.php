<?php

session_start();
session_unset();
session_destroy();
echo "<script>window.location.href='http://127.0.0.1/freshcerry/';</script>";
