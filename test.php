<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$str = "Cardholder's name : special characters ($ # ! ? ..) are not allowed";
echo str_replace('\'', '', $str);
