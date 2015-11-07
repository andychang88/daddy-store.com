<?php
      // note: we can later move part of this function into sub-functions, which we can store in the base class.
    class SSULanguageEs extends SSULanguage{      
        static function parseName($name){
            $cyrillic = array("ñ",  "á",  "é", "í",  "ó", "ú");
             
            $translit = array("n", "a", "e", "i", "o",  "u");
            
            $name = str_replace($cyrillic, $translit, $name);
            
            $name = strtolower($name);
       
            // we replace any non alpha numeric characters by the name delimiter
            $name = self::removeNonAlphaNumeric($name, SSUConfig::registry('delimiters', 'name'));
            
            // Remove short words first
            $name = self::removeShortWords($name, SSUConfig::registry('configs', 'minimum_word_length'), SSUConfig::registry('delimiters', 'name'));
            
            // trim the sentence
            $name = self::trimLongName($name);
                    
            // remove excess SSUConfig::registry('delimiters', 'name')
            $name = self::removeDelimiter($name);
            
            // remove identifiers
            $name = self::removeIdentifiers($name);
            
            // remove trailing _
            $name = trim($name, SSUConfig::registry('delimiters', 'name'));
            
            return urlencode($name);
        }
    } 