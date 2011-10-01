<?php

require_once 'phpIPTC.php';
require_once 'phpIPTCtags.php';

class phpIPTCcounter extends phpIPTC {

    var $value;

    function get () {
        $iptc = new phpIPTCtags ($this->file);
        $this->value = $iptc->read (120) + 1;
        $this->makeImage ($this->width * $this->height == 1 ? null:$this->value);
        $iptc->set (120, $this->value);
        $iptc->write ();
        return ($this->file);
    }

}

?>
