<?php

$mods = get_declared_classes();
foreach($mods as $mod) {
    echo 'mod ' . $mod . "<br/>";

}
$funcs = get_defined_functions();
foreach($funcs as $mod) {
    echo 'func ' . print_r($mod, 1) . "<br/>";

}

$exts = get_loaded_extensions();
foreach($exts as $ext) {
    echo "ext $ext<br/>";
    $funcs = get_extension_funcs($ext);
    foreach($funcs as $ext2) {
        echo "$ext/$ext2<br/>";
    }
}
phpinfo();
