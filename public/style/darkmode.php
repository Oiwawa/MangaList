<?php
$themeClass = '';

if(!empty($_COOKIE['theme'])){
    $themeClass ='dark-theme';
} elseif ($_COOKIE['theme'] == 'light'){
    $themeClass = 'light-theme';
}
?>