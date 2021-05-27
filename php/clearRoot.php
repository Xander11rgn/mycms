<?php
function clearRoot($dir)
{
    $d = opendir($dir);
    while (($entry = readdir($d)) !== false) {
        if ($entry != "." && $entry != "..") {
            if (is_dir($dir . "/" . $entry)) {
                clearRoot($dir . "/" . $entry);
            } else {
                unlink($dir . "/" . $entry);
            }
        }
    }
    closedir($d);
    rmdir($dir);
}

function clearRoot2($dir) {
    $d = opendir($dir);
    while (($entry = readdir($d)) !== false) {
        if ($entry != "." && $entry != "..") {
            if (!is_dir($dir . "/" . $entry)) {
                unlink($dir . "/" . $entry);
            }
        }
    }
    closedir($d);
}