<?php

function strip_zeros_from_date( $marked_string="" ) {
    // first remove the marked zeros
    $no_zeros = str_replace('*0', '', $marked_string);
    // then remove any remaining marks
    $cleaned_string = str_replace('*', '', $no_zeros);
    return $cleaned_string;
}

function redirect_to( $location = NULL ) {
    if ($location != NULL) {
        header("Location: {$location}");
        exit;
    }
}

function __autoload($class_name) {
    $class_name = strtolower($class_name);
    $path = LIB_PATH.DS.$class_name.'php';
    if (file_exists($path)) {
        require_once($path);
    } else {
        die("The file {$class_name}.php could not be found.");
    }
}

function include_layout_template($template='') {
    // no variables in inherited scope
    include(SITE_ROOT.DS.'public_html'.DS.'layouts'.DS.$template);
}

function marked_to_ruby($marked) {
    $ruby;
    for ($i=0; $i<strlen($marked); $i+=J_SIZE) {
        $char = substr($marked,$i,J_SIZE);
        if ($char=="「") {
            $ruby .= "<ruby>";
        } elseif ($char=="（") {
            $ruby .= "<rt>";
        } elseif ($char=="）") {
            $ruby .= "</rt></ruby>";
        } else {
            $ruby .= $char;
        }
    }
    return $ruby;
}

function marked_to_hrgn($marked) {
    $hrgn;
    $deleting = false;
    for ($i=0; $i<strlen($marked); $i+=J_SIZE) {
        $char = substr($marked,$i,J_SIZE);
        if ($char=="「") {
            $deleting = true;
        } elseif ($char=="（") {
            $deleting = false;
        } elseif ($char=="）") {
            // ignore
        } elseif (!$deleting) {
            $hrgn .= $char;
        }
    }
    return $hrgn;
    
}

function marked_to_kanji($marked) {
    $kanji;
    $deleting = false;
    for ($i=0; $i<strlen($marked); $i+=J_SIZE) {
        $char = substr($marked,$i,J_SIZE);
        if ($char=="「") {
            // ignore
        } elseif ($char=="（") {
            $deleting = true;
        } elseif ($char=="）") {
            $deleting = false;
        } elseif (!$deleting) {
            $kanji .= $char;
        }
    }
    return $kanji;
    
}

?>