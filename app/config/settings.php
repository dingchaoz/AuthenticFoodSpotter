<?php
// filename: app/config/settings.php

$list = array();

$format = function(&$list, $keys, $val) use(&$format) {
    $keys ? $format($list[array_shift($keys)], $keys, $val) : $list = $val;
};

foreach(Setting::all() as $setting) {
    $format($list, explode('.', $setting->option), $setting->value);
}

return $list;