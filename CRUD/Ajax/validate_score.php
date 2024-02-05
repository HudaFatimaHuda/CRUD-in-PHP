<?php
    include "../oop/validation.php";
    $score = $_GET["q"];
    echo Validation::scoreValidation($score);
?>