<?php
  	// note: we can later move part of this function into sub-functions, which we can store in the base class.
	class SSULanguageRu extends SSULanguage{
		static function parseName($name){
			$cyrillic = array("ж",  "ё",  "й", "ю",  "ь", "ч",  "щ",  "ц", "у", "к", "е", "н", "г", "ш",  "з", "х", "ъ", "ф", "ы", "в", "а", "п", "р", "о", "л", "д", "э", "я",  "с", "м", "и", "т", "б", "Ё",  "Й", "Ю",  "Ч",  "Ь", "Щ",  "Ц", "У", "К", "Е", "Н", "Г", "Ш",  "З", "Х", "Ъ", "Ф", "Ы", "В", "А", "П", "Р", "О", "Л", "Д", "Ж",  "Э",  "Я",  "С", "М", "И", "Т", "Б");
     		
			$translit = array("zh", "yo", "i", "yu", "",  "ch", "sh", "c", "u", "k", "e", "n", "g", "sh", "z", "h", "",  "f", "y", "v", "a", "p", "r", "o", "l", "d", "ye","ya", "s", "m", "i", "t", "b", "yo", "I", "YU", "CH", "",  "SH", "C", "U", "K", "E", "N", "G", "SH", "Z", "H", "",  "F", "Y", "V", "A", "P", "R", "O", "L", "D", "Zh", "Ye", "Ya", "S", "M", "I", "T", "B");
			
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
		}
	}