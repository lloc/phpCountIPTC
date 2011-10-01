<?php

class phpIPTCtags {

    var $file;

    function phpIPTCtags ($file) {
        if (is_file ($file)) {
            $this->file = $file;
            return ($this);
        }
        return (FALSE);
    }

    function read ($tag = null) {
        if (is_readable ($this->file)) {
            GetImageSize ($this->file, &$info);
            if (isset ($info["APP13"])) {
                $this->iptc = iptcparse ($info["APP13"]);
            }
        }
        return (!is_null ($tag) ? $this->iptc["2#" . $tag][0]:$this->iptc);
    }

    function set ($tag, $input) {
        if (!empty ($tag) && !empty($input) && isset ($this->iptc)) {
            $this->iptc["2#" . $tag][0] = $input;
        }
    }

    function write () {
        if (isset ($this->iptc) && is_writable ($this->file)) {
            $tags = '';
            foreach (array_keys ($this->iptc) as $s){
                $tags .= $this->tag (2, str_replace ("2#", "", $s), $this->iptc[$s][0]);
            }
            $content = iptcembed ($tags, $this->file, 0);
            $fp = fopen ($this->file, "w");
            fwrite ($fp, $content);
            fclose ($fp);
        }
    }
    
    // Function to format the new IPTC text, (thanks to Thies C. Arntzen)
    function tag ($rec, $dat, $val) {
        $len = strlen ($val);
        if ($len < 0x8000) {
            return (
                chr (0x1c).chr($rec).chr($dat) .
                chr ($len >> 8) .
                chr ($len & 0xff) .
                $val
            );
        }
        return (
            chr (0x1c).chr($rec).chr($dat) .
            chr (0x80).chr(0x04) .
            chr (($len >> 24) & 0xff) .
            chr (($len >> 16) & 0xff) .
            chr (($len >> 8 ) & 0xff) .
            chr (($len ) & 0xff).
            $val
        );
    }

}

?>
