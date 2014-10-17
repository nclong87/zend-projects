<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// Create image instances
$src = imagecreatefromjpeg('/tmp/test.jpg');
$dest = imagecreatetruecolor(80, 40);

// Copy
imagecopy($dest, $src, 0, 0, 20, 13, 80, 40);

unlink('/tmp/test2.jpg');
image2wbmp($dest, '/tmp/test2.jpg');
//imagegd($dest, '/tmp/test2.jpg');
// Output and free from memory

imagedestroy($dest);
imagedestroy($src);