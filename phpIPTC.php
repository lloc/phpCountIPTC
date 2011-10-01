<?php

class phpIPTC {

    var $file;
    var $background = '000000';
    var $color = 'FFFFFF';
    var $width;
    var $height = 20;

    function phpIPTC ($arr = array ()) {
        $this->set ($arr);
    }

    function set ($arr) {
        if (is_array ($arr) && !empty ($arr)) {
            foreach ($arr as $key => $value) {
                if (in_array ($key, array_keys (get_class_vars (get_class ($this))))) {
                    $this->$key = $arr[$key];
                }
            }
        }
    }

    function makeImage ($input) {
        if (is_writable ($this->file)) {
            $im = imagecreatetruecolor (!empty ($this->width) ? $this->width : (strlen ($input) * 8) + 4, $this->height);
            imagefill ($im, 0, 0, $this->allocateFromHex ($im, $this->background));
            if (!is_null ($input)) {
                imagestring ($im, 4, 2, 2, $input, $this->allocateFromHex ($im, $this->color));
            }
            imagejpeg ($im, $this->file, 80);
            imagedestroy ($im);
        }
    }

    function allocateFromHex ($im, $hexstr) {
        $int = hexdec ($hexstr);
        return (imagecolorallocate ($im, 0xFF & ($int >> 0x10), 0xFF & ($int >> 0x8), 0xFF & $int));
    }

}

?>
