<?php

namespace Core;

class ImageUtils {

    public static function getWidthHeight($path, $type) {
        if ($type == 'jpeg') {
            $type = 'jpg';
        }
        switch ($type) {
            case 'bmp':
                $image = imagecreatefromwbmp($path);
                break;
            case 'gif':
                $image = imagecreatefromgif($path);
                break;
            case 'jpg':
                $image = imagecreatefromjpeg($path);
                break;
            case 'png':
                $image = imagecreatefrompng($path);
                break;
            default:
                return "Unsupported picture type!";
        }
        if ($image == null) {
            return null;
        }
        return array(
            'width' => imagesx($image),
            'height' => imagesy($image)
        );
    }

    public static function image_resize($src, $type, $dst, $width, $height, $crop = 0) {
        if (($info = getimagesize($src)) == null) {
            return;
        }
        $origWidth = $info[0];
        $origHeight = $info[1];
        $type = $info[2];
        switch ($type) {
            case IMAGETYPE_BMP:
                $img = imagecreatefromwbmp($src);
                break;
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($src);
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($src);
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($src);
                break;
            default:
                throw new Exception('Error');
        }
        // resize
        if ($crop) {
            if ($width == null) { //fix height
                $ratio = $height / $origHeight;
                $x = ($origHeight - $height / $ratio) / 2;
                $newHeight = $height;
                $newWidth = $origWidth / $ratio;
            } elseif ($height == null) { //fix width
                $ratio = $width / $origWidth;
                $x = ($origWidth - $width / $ratio) / 2;
                $newWidth = $width;
                $newHeight = $origHeight / $ratio;
            } else {
                if ($origWidth < $width || $origHeight < $height) {
                    return array(
                        'rs' => 0,
                        'new_width' => $origWidth,
                        'new_height' => $origHeight
                    );
                }
                $newHeight = $height;
                $x = ($origWidth - $width / $ratio) / 2;
                $newWidth = $width;
            }
        } else {
            if ($width == null) { //fix height
                if ($origHeight < $height) {
                    return array(
                        'rs' => 0,
                        'new_width' => $origWidth,
                        'new_height' => $origHeight
                    );
                }
                $ratio = round($origHeight / $height, 2);
                $newHeight = $height;
                $newWidth = ceil($origWidth / $ratio);
                $x = 0;
            } elseif ($height == null) { //fix width
                if ($origWidth < $width) {
                    return array(
                        'rs' => 0,
                        'new_width' => $origWidth,
                        'new_height' => $origHeight
                    );
                }
                $ratio = round($origWidth / $width, 2);
                $newWidth = $width;
                $newHeight = ceil($origHeight / $ratio);
                $x = 0;
            } else {
                if ($origWidth < $width && $origHeight < $height) {
                    return array(
                        'rs' => 0,
                        'new_width' => $origWidth,
                        'new_height' => $origHeight
                    );
                }
                $newWidth = $width;
                $newHeight = $height;
                $x = 0;
            }
        }
        $new = imagecreatetruecolor($newWidth, $newHeight);
        // preserve transparency
        if ($type == IMAGETYPE_GIF or $type == IMAGETYPE_PNG) {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, $x, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        switch ($type) {
            case IMAGETYPE_BMP:
                imagewbmp($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_GIF:
                imagegif($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_PNG:
                imagepng($new, $dst, 9);
                break;
        }
        return array(
            'rs' => 1,
            'new_width' => $newWidth,
            'new_height' => $newHeight
        );
    }

    public static function image_resize_ratio($src, $type, $dst, $size) {
        if (($info = getimagesize($src)) == null) {
            throw new Exception('Error');
        }
        $origWidth = $info[0];
        $origHeight = $info[1];
        $type = $info[2];
        switch ($type) {
            case IMAGETYPE_BMP:
                $img = imagecreatefromwbmp($src);
                break;
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($src);
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($src);
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($src);
                break;
            default:
                throw new Exception('Error');
        }
        // resize
        if ($origWidth < $size and $origHeight < $size) {
            return array(
                'rs' => 0,
                'new_width' => $origWidth,
                'new_height' => $origHeight
            );
        }
        if ($origWidth > $origHeight) {
            $ratio = round($origWidth / $size, 2);
            $newWidth = $size;
            $newHeight = ceil($origHeight / $ratio);
        } elseif ($origHeight > $origWidth) {
            $ratio = round($origHeight / $size, 2);
            $newHeight = $size;
            $newWidth = ceil($origWidth / $ratio);
        } else {
            $newWidth = $size;
            $newHeight = $size;
        }
        $x = 0;
        $new = imagecreatetruecolor($newWidth, $newHeight);
        // preserve transparency
        if ($type == IMAGETYPE_GIF or $type == IMAGETYPE_PNG) {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, $x, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        switch ($type) {
            case IMAGETYPE_BMP:
                imagewbmp($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_GIF:
                imagegif($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_PNG:
                imagepng($new, $dst, 9);
                break;
        }
        return array(
            'rs' => 1,
            'new_width' => $newWidth,
            'new_height' => $newHeight
        );
    }

    public static function getImageFromUrl($link, $dst_folder, $filename, $size = '') {
        ini_set('user_agent', 'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1) Gecko/20090615 Firefox/3.5');
        $info = get_headers($link);
        if (empty($info)) {
            throw new Exception('Error');
        }
        foreach ($info as $str) {
            preg_match('/(.*?): (.*?)$/', $str, $matches);
            //preg_match('/Content-Length: (.*?)$/', $str, $matches);
            if ($matches != null && isset($matches[2])) {
                if ($matches[1] == 'Content-Length') {
                    if ($matches[2] > URL_UPLOAD_MAX_FILE_SIZE) {
                        throw new Exception('Error');
                    }
                } else if ($matches[1] == 'Content-Type') {
                    if (strpos($matches[2], 'image') === false) {
                        throw new Exception('Error');
                    }
                }
            }
        }

        $handle = fopen($link, "rb");
        $contents = "";
        $count = 0;
        if ($handle) {
            do {
                $count += 1;
                $data = fread($handle, 1024);
                if (strlen($data) == 0) {
                    break;
                }
                $contents .= $data;
            } while (true);
        } else {
            return false;
        }
        fclose($handle);
        $tmp_filepath = '/tmp/' . $filename . '_tmp';
        $handle = fopen($tmp_filepath, 'w');
        if ($handle == null) {
            throw new Exception('Error');
        }
        fwrite($handle, $contents);
        fclose($handle);
        $info = getimagesize($tmp_filepath);
        if (empty($info)) {
            throw new Exception('Error');
        }
        $origWidth = $info[0];
        $origHeight = $info[1];
        $type = $info[2];
        $sType = '';
        switch ($type) {
            case IMAGETYPE_BMP:
                $img = imagecreatefromwbmp($tmp_filepath);
                $sType = '.bmp';
                break;
            case IMAGETYPE_GIF:
                $img = imagecreatefromgif($tmp_filepath);
                $sType = '.gif';
                break;
            case IMAGETYPE_JPEG:
                $img = imagecreatefromjpeg($tmp_filepath);
                $sType = '.jpg';
                break;
            case IMAGETYPE_PNG:
                $img = imagecreatefrompng($tmp_filepath);
                $sType = '.png';
                break;
            default:
                throw new Exception('Error');
        }
        if($size == '') {
            $size = $origWidth;
        }
        if ($size < $origWidth) {
            $ratio = round($origWidth / $size, 2);
            $newWidth = $size;
            $newHeight = ceil($origHeight / $ratio);
        } else {
            $newWidth = $origWidth;
            $newHeight = $origHeight;
        }

        $new = imagecreatetruecolor($newWidth, $newHeight > $size ? $size : $newHeight);
        // preserve transparency
        if ($type == IMAGETYPE_GIF or $type == IMAGETYPE_PNG) {
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }
        imagecopyresampled($new, $img, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);
        $dst = $dst_folder . '/' . $filename . $sType;
        switch ($type) {
            case IMAGETYPE_BMP:
                imagewbmp($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_GIF:
                imagegif($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_JPEG:
                imagejpeg($new, $dst, DEFAULT_IMAGE_RESIZE_QUALITY);
                break;
            case IMAGETYPE_PNG:
                imagepng($new, $dst, 9);
                break;
        }
        //unlink($tmp_filepath);
        return $filename . $sType;
    }
    
    public static function saveImage($url,$filepath) {
        $content = file_get_contents($url);
        file_put_contents($filepath, $content);
    }

}