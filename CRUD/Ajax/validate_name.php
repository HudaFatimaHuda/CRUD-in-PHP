<?php
    include "../oop/validation.php";
    $name = $_GET["q"];
    echo Validation::nameValidation($name);
?>