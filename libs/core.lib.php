<?php 

	
	function preprint_r($arr)
	{
		echo "<pre>".print_r($arr,true)."</pre>";
	}
	
	function echoN($str)
	{
		echo($str."\n<br>");
	}
	
	function multibyteStringOrdinal($str)
	{
	
		$ordinals = array();
		$convertedStr = mb_convert_encoding($str,"UCS-4BE","UTF-8");
	
	
		for($i=0;$i<mb_strlen($convertedStr,"UCS-4BE"); $i++)
		{
		
			$char = mb_substr($convertedStr,$i,1,"UCS-4BE");
			$charDecValArr = unpack("N",$char);
			 
			//preprint_r($charDecValArr);
			 
			$ordinals[] = $charDecValArr[1];
		}
		 
		return $ordinals;
	}
		
	function multibyteCharOrdinal($str)
	{       

		$ordinals = array();
	    $convertedStr = mb_convert_encoding($str,"UCS-4BE","UTF-8");
        $char = mb_substr($convertedStr,0,1,"UCS-4BE");  
        
        $charDecValArr = unpack("N",$char);    
   
        //preprint_r($charDecValArr);
	    
	    return $charDecValArr[1];
	}
	
	function showHiddenChars($text,$lang="AR")
	{
		 
		if ( $lang=="AR")
		{
				for($index=0;$index<mb_strlen($text);$index++)
				{
					$chr =mb_substr($text,$index,1);
					echoN($chr."|".urlencode($chr));
					}
				}
		else
		{
				for($index=0;$index<strlen($text);$index++)
				{
					$chr =substr($text,$index,1);
					echoN($chr."|".urlencode($chr));
				}
		}
			exit;
	
				
	}
	
	function addCommasToNumber($numStr)
	{
		$negativeFlag=false;
		if ( strpos($numStr,"-")!==false)
		{
			$negativeFlag=true;
			$numStr = substr($numStr,1);
		}
		
		$len = strlen($numStr);
		
		$strArr = str_split($numStr);
		//print_r($strArr);
		
		$newNumStr = "";
		$couner =0;
		for($i=$len-1;$i>=0;$i--)
		{
			$newNumStr .=  $strArr[$i];
			$couner++;
			
			if ( $couner%3==0 && $i!=0)
			{
				$newNumStr .=",";
			}
		}
		
		$newNumStr = strrev($newNumStr);
		
		if ( $negativeFlag==true)
		{
			$newNumStr = "-".$newNumStr;
		}
		
		return $newNumStr;	
	}
	

	function rsortBy(&$arrayToSort, $field)
	{
		
		
		 uasort($arrayToSort, function($a, $b) use ($field) {
			
			//**** 1 and -1 are switched to make the reverse functionality
			if ($a[$field]==$b[$field] )
			{
				return -0;
			}
			else if ($a[$field]>$b[$field]  )
			{
				return -1;
			}
			else
			{
				return 1;
			}
			
		});
	
		
	
	}
	
	


	function shuffle_assoc(&$arr)
	{
		$keys = array_keys($arr);
		
		shuffle($keys);
		
		foreach ($keys as $key)
		{
		    $shuffled_array[$key] = $arr[$key];
		}

		$arr = $shuffled_array;
	}
	
	function removeTashkeel($str)
	{
		return preg_replace("/[\x{0618}-\x{061A}\x{064B}-\x{0654}\x{0670}-\x{0671}\x{06DC}\x{06DF}\x{06E0}\x{06E2}\x{06E3}\x{06E5}\x{06E6}\x{06E8}\x{06EA}-\x{06ED}]/um","",$str);
		
	}
	
	function stripBOM($str)
	{
		$BOM =  chr(239) . chr(187) . chr(191);
		return trim(($str),$BOM);
	}
	
	function cleanAndTrim($str)
	{
		//« spoils arabic words = 0xab
		$tobeReplacedStr = "\t\n\r\0\x0B~!$%&;^*()+=-<>?\"',”“.][»";
		return trim(trim($str),$tobeReplacedStr);
	}

	
	function isArabicString($str)
	{
			
			
		$mbResult = false;
		$arabicChars = "ء|آ|أ|ؤ|إ|ئ|ا|ب|ة|ت|ث|ج|ح|خ|د|ذ|ر|ز|س|ش|ص|ض|ط|ظ|ع|غ|ف|ق|ك|ل|م|ن|ه|و|ى|ي|٫|ٮ|ٯ";
		$mbResult = mb_ereg("[$arabicChars]+", $str);
		
		
		if ($mbResult===FALSE)
		{
			$arabicCharsPresentationForms = "ﺇ|ﺆ|ﺅ|ﺄ|ﺃ|ﺂ|ﺁ|ﺀ|ﺟ|ﺞ|ﺝ|ﺜ|ﺛ|ﺚ|ﺙ|ﺘ|ﺗ|ﺖ|ﺕ|ﺔ|ﺓ|ﺒ|ﺑ|ﺐ|ﺏ|ﺎ|ﺍ|ﺌ|ﺋ|ﺊ|ﺉ|ﺈ|ﺷ|ﺶ|ﺵ|ﺴ|ﺳ|ﺲ|ﺱ|ﺰ|ﺯ|ﺮ|ﺭ|ﺬ|ﺫ|ﺪ|ﺩ|ﺨ|ﺧ|ﺦ|ﺥ|ﺤ|ﺣ|ﺢ|ﺡ|ﺠ|ﻏ|ﻎ|ﻍ|ﻌ|ﻋ|ﻊ|ﻉ|ﻈ|ﻇ|ﻆ|ﻅ|ﻄ|ﻃ|ﻂ|ﻁ|ﺿ|ﺾ|ﺽ|ﺼ|ﺻ|ﺺ|ﺹ|ﺸ|ﻧ|ﻦ|ﻥ|ﻤ|ﻣ|ﻢ|ﻡ|ﻠ|ﻟ|ﻞ|ﻝ|ﻜ|ﻛ|ﻚ|ﻙ|ﻘ|ﻗ|ﻖ|ﻕ|ﻔ|ﻓ|ﻒ|ﻑ|ﻐ|ﻼ|ﻻ|ﻺ|ﻹ|ﻷ|ﻸ|ﻶ|ﻵ|ﻴ|ﻳ|ﻲ|ﻱ|ﻰ|ﻯ|ﻮ|ﻭ|ﻬ|ﻫ|ﻪ|ﻩ|ﻨ";
			$mbResult = mb_ereg("[$arabicCharsPresentationForms]+", $str);
		}
			
		return ($mbResult!==FALSE);
	
	
	
	}
	

	
	/** My own implementation of Levenstein algorithm since the official one is not multilingual**/
	function myLevensteinEditDistance($word1,$word2)
	{
		$word1Length  = mb_strlen($word1);
		$word2Length  = mb_strlen($word2);
		
		$matrix = array();
		
		for($i=0;$i<$word1Length+1; $i++)
		{
			for($v=0;$v<$word2Length+1; $v++)
			{
				if ($i==0 ) $matrix[$i][$v] =$v;
				else if ($v ==0 )$matrix[$i][$v] =$i;
				else $matrix[$i][$v] =0;
			}
			
		}
		
		for($i=1;$i<$word1Length+1; $i++)
		{
			for($v=1;$v<$word2Length+1; $v++)
			{
				$charIWord1 = mb_substr($word1,$i-1,1);
				$charIWord2 = mb_substr($word2,$v-1,1);
				
				
				
				$substitutionCost = ($charIWord1!=$charIWord2) ? 1 : 0;
				
				//echoN("$charIWord1 $charIWord2 $substitutionCost");
				
				$matrix[$i][$v] = min(array($matrix[$i-1][$v]+1,$matrix[$i][$v-1]+1,$matrix[$i-1][$v-1]+$substitutionCost));
			}
				
		}
		
		//print2dArray($matrix);
		

		
		return $matrix[$i-1][$v-1];
		
	}
	
	function getHammingDistance($word1,$word2)
	{
		$distance=0;
		
		for($i=0;$i<mb_strlen($word1); $i++)
		{
			
			$charIWord1 = mb_substr($word1,$i,1);
			$charIWord2 = mb_substr($word2,$i,1);
		
			
			if ( $charIWord1!=$charIWord2)
			{
				$distance++;
			}
		}
		
		return $distance;
			
	}
	
	function getDistanceBetweenWords($word1,$word2)
	{
		$distance=0;
		
		$word1Length  = mb_strlen($word1);
		$word2Length  = mb_strlen($word2);
		
		if ( $word1Length==$word2Length)
		{
			//echoN("EQUAL");
			return getHammingDistance($word1,$word2);
		}
		else
		{

			return myLevensteinEditDistance($word1,$word2);

		}
	}
	
	function print2dArray($match2dArray)
	{
		
		if (empty($match2dArray)){ return null;}
		
		for ($i=0;$i<count($match2dArray);$i++)
		{
			
			
			for ($v=0;$v<count($match2dArray[$i]);$v++)
			{
				echo $match2dArray[$i][$v]."|";
				
			}
			
			echo "<br>\n";
		}
			echo "<br>\n";
	}
	
	/* Return the other supported language which should be different from the current one
	*  Mainly EN/AR 
	*/
	function toggleLanguage($currentLang)
	{
		
		$otherLanguage = "AR";
		
		if ($currentLang=="AR" )
		{
			return "EN";
		}
		
		return $otherLanguage;
		
	}
	

	function getStopWordsArrByFile($stopWordsFile)
	{
		$stopWordsArrTemp = file($stopWordsFile,FILE_SKIP_EMPTY_LINES  | FILE_IGNORE_NEW_LINES);
		

		$stopWordsArr = array();
		foreach($stopWordsArrTemp as $stopWord)
		{
			/* dont use cleanAndTrim here .. it will remove "'"   in you'ar 
			 * also it will spoil JSON ENCODING for some reason i don't know 
			 */
			$stopWord = (stripBOM($stopWord));
			$stopWordsArr[$stopWord] = 1;
		}
		
		return $stopWordsArr;
	}
	
	function getPauseMarksArrByFile($pauseMarksFile)
	{

		$pauseMarksArrTemp = file($pauseMarksFile,FILE_SKIP_EMPTY_LINES  | FILE_IGNORE_NEW_LINES);
		
		$pauseMarksArr  = array();
		
		
		foreach($pauseMarksArrTemp as $pauseMark)
		{
		
			$pauseMark = trim(($pauseMark));
		
			//echoN(multibyteCharOrdinal($pauseMark));
		
			$pauseMarksArr[$pauseMark]=1;
		}
		
		return $pauseMarksArr;
	}
	
	/**
	 * Buckwalter reverse translation based on table on QAC website
	 * http://corpus.quran.com/java/buckwalter.jsp
	 * 
	 * 
	 * @param String $transliteratedStr 
	 * @return string
	 */
	function buckwalterReverseTransliteration($transliteratedStr)
	{
	
			$reverseTransliteratedStr = "";
		
			$BUCKWATER_EXTENDED_MAP = array();
			
			$BUCKWATER_EXTENDED_MAP["'"]=1569;
			$BUCKWATER_EXTENDED_MAP[">"]=1571;
			$BUCKWATER_EXTENDED_MAP["&"]=1572;
			$BUCKWATER_EXTENDED_MAP["<"]=1573;
			$BUCKWATER_EXTENDED_MAP["}"]=1574;
			$BUCKWATER_EXTENDED_MAP["A"]=1575;
			$BUCKWATER_EXTENDED_MAP["b"]=1576;
			$BUCKWATER_EXTENDED_MAP["p"]=1577;
			$BUCKWATER_EXTENDED_MAP["t"]=1578;
			$BUCKWATER_EXTENDED_MAP["v"]=1579;
			$BUCKWATER_EXTENDED_MAP["j"]=1580;
			$BUCKWATER_EXTENDED_MAP["H"]=1581;
			$BUCKWATER_EXTENDED_MAP["x"]=1582;
			$BUCKWATER_EXTENDED_MAP["d"]=1583;
			$BUCKWATER_EXTENDED_MAP["*"]=1584;
			$BUCKWATER_EXTENDED_MAP["r"]=1585;
			$BUCKWATER_EXTENDED_MAP["z"]=1586;
			$BUCKWATER_EXTENDED_MAP["s"]=1587;
			$BUCKWATER_EXTENDED_MAP["$"]=1588;
			$BUCKWATER_EXTENDED_MAP["S"]=1589;
			$BUCKWATER_EXTENDED_MAP["D"]=1590;
			$BUCKWATER_EXTENDED_MAP["T"]=1591;
			$BUCKWATER_EXTENDED_MAP["Z"]=1592;
			$BUCKWATER_EXTENDED_MAP["E"]=1593;
			$BUCKWATER_EXTENDED_MAP["g"]=1594;
			$BUCKWATER_EXTENDED_MAP["_"]=1600;
			$BUCKWATER_EXTENDED_MAP["f"]=1601;
			$BUCKWATER_EXTENDED_MAP["q"]=1602;
			$BUCKWATER_EXTENDED_MAP["k"]=1603;
			$BUCKWATER_EXTENDED_MAP["l"]=1604;
			$BUCKWATER_EXTENDED_MAP["m"]=1605;
			$BUCKWATER_EXTENDED_MAP["n"]=1606;
			$BUCKWATER_EXTENDED_MAP["h"]=1607;
			$BUCKWATER_EXTENDED_MAP["w"]=1608;
			$BUCKWATER_EXTENDED_MAP["Y"]=1609;
			$BUCKWATER_EXTENDED_MAP["y"]=1610;
			$BUCKWATER_EXTENDED_MAP["F"]=1611;
			$BUCKWATER_EXTENDED_MAP["N"]=1612;
			$BUCKWATER_EXTENDED_MAP["K"]=1613;
			$BUCKWATER_EXTENDED_MAP["a"]=1614;
			$BUCKWATER_EXTENDED_MAP["u"]=1615;
			$BUCKWATER_EXTENDED_MAP["i"]=1616;
			$BUCKWATER_EXTENDED_MAP["~"]=1617;
			$BUCKWATER_EXTENDED_MAP["o"]=1618;
			$BUCKWATER_EXTENDED_MAP["^"]=1619;
			$BUCKWATER_EXTENDED_MAP["#"]=1620;
			$BUCKWATER_EXTENDED_MAP["`"]=1648;
			$BUCKWATER_EXTENDED_MAP["{"]=1649;
			$BUCKWATER_EXTENDED_MAP[":"]=1756;
			$BUCKWATER_EXTENDED_MAP["@"]=1759;
			$BUCKWATER_EXTENDED_MAP["\""]=1760;
			$BUCKWATER_EXTENDED_MAP["["]=1762;
			$BUCKWATER_EXTENDED_MAP[";"]=1763;
			$BUCKWATER_EXTENDED_MAP[","]=1765;
			$BUCKWATER_EXTENDED_MAP["."]=1766;
			$BUCKWATER_EXTENDED_MAP["!"]=1768;
			$BUCKWATER_EXTENDED_MAP["-"]=1770;
			$BUCKWATER_EXTENDED_MAP["+"]=1771;
			$BUCKWATER_EXTENDED_MAP["%"]=1772;
			$BUCKWATER_EXTENDED_MAP["]"]=1773;
				
			
	
			

	
			//echoN(strlen($transliteratedStr));

			for($index=0;$index<strlen($transliteratedStr);$index++)
			{
				$char =substr($transliteratedStr,$index,1);
					
				// stop if char not a buckwalter char or space
				if ( !isset($BUCKWATER_EXTENDED_MAP[$char]) && $char!=" " && $char!="2" )
				{
					throw new Exception("Input string is not pure Buckwalter transliteration! [$char]");
				}
				/*
				 * Comments from Stackoverflow about the conversion below
				* UCS-4BE is a Unicode encoding which stores each character as a 32-bit (4 byte) integer. This accounts for the "UCS-4"; the "BE" prefix indicates that the integers are stored in big-endian order. The reason for this encoding is that, unlike smaller encodings (like UTF-8 or UTF-16), it requires no surrogate pairs -- each character is a fixed size.
				* http://stackoverflow.com/questions/11304582/searching-for-a-good-unicode-compatible-alternative-to-the-php-ord-function/11304763#11304763
				*/
				
					
				// convert from decimal to binary string in 'UCS-4BE' encoding
				// N  = unsigned long (always 32 bit, big endian byte order)
				// http://php.net/manual/en/function.pack.php
				$char = (pack('N',$BUCKWATER_EXTENDED_MAP[$char]));
					
				// convert from 32 bit encoding to Arabic "UTF-8"
				$char = mb_convert_encoding($char, "UTF-8", 'UCS-4BE');
					
				//echoN("|".$char."|");
				
				$reverseTransliteratedStr = $reverseTransliteratedStr . $char;
			}
			
			
			
			return $reverseTransliteratedStr;
		
		
	}
	
	function stripHTMLComments($xmlContent)
	{
		return (preg_replace('/<!--.*-->/s', "", $xmlContent));

	}
	
	function getQACSegmentByQuranaSeqment($qacMasterSegmentTable,$suraID,$verseID,$verseLocalSegmentIndex,$quranaSegmentForm)
	{
		$masterIDPrefix = "$suraID:$verseID:";
		
		$currentSegment = 0;
		$currentWordIndex = 1;
		
		$masterID = $masterIDPrefix.$currentWordIndex;
		
		//preprint_r($qacMasterSegmentTable);
		
		$matchingSegmentLocation = -1;
		
		while( isset($qacMasterSegmentTable[$masterID]))
		{
			$segmentsInWord = $qacMasterSegmentTable[$masterID];
			
			
			
			foreach($segmentsInWord as $segmentArr)
			{
				
				
				$currentSegment++;
				
				//echoN("MASTER ID:$masterID SEG:$currentSegment PASSED SEG:$verseLocalSegmentIndex");
				
				//echoN("$quranaSegmentForm - ".$segmentArr['FORM_AR']);
				
				/*if ( $quranaSegmentForm== $segmentArr['FORM_AR'])
				{
					return $segmentArr['SEGMENT_INDEX'];
				}*/
				
				if ( $currentSegment== $verseLocalSegmentIndex)
				{
					$matchingSegmentLocation = $segmentArr['SEGMENT_INDEX'];;
				}
				
			}
			
			$currentWordIndex++;
			$masterID = $masterIDPrefix.$currentWordIndex;
			
		}
		
		return $matchingSegmentLocation;
		
	}
	function getWordIndexByQACSegment($qacMasterSegmentTable,$suraID,$verseID,$segmentID)
	{
		$masterIDPrefix = "$suraID:$verseID:";
		
		$currentSegment = 0;
		$currentWordIndex = 1;
		
		$masterID = $masterIDPrefix.$currentWordIndex;
		
		
		while( isset($qacMasterSegmentTable[$masterID]))
		{
			$segmentsInWord = $qacMasterSegmentTable[$masterID];
			
			foreach($segmentsInWord as $segmentArr)
			{
				
				
				$currentSegment = $segmentArr['SEGMENT_INDEX'];;
				
				echoN("MASTER ID:$masterID SEG:$currentSegment PASSED SEG:$segmentID");
				
				if ( $segmentID== $currentSegment)
				{
					return $currentWordIndex;
				}
				
			}
			
			$currentWordIndex++;
			$masterID = $masterIDPrefix.$currentWordIndex;
			
		}
		
		return null;
		
		
		
	}
	
	function addToInvertedIndex(&$INVERTED_INDEX,$word,$suraID,$verseID,$wordIndex,$wordType,$extraInfo=null)
	{
		if (!isset($INVERTED_INDEX[$word]) ) $INVERTED_INDEX[$word] = array();
		
		$indexInAyaName = "INDEX_IN_AYA_EMLA2Y";
		
		if ($wordType!="NORMAL_WORD")
		{
			$indexInAyaName = "INDEX_IN_AYA_UTHMANI";
		}
		
		$INVERTED_INDEX[$word][] = array("SURA"=>$suraID,"AYA"=>$verseID,"$indexInAyaName"=>$wordIndex,"WORD_TYPE"=>"$wordType","EXTRA_INFO"=>$extraInfo);
		
	
	}
	
	function getVerseByQACLocation($MODEL_CORE,$qac3PartLocationStr)
	{
		
		
		if ( strpos($qac3PartLocationStr,":")===false)
		{
			throw new Exception("Invalid QAC location");
		}
		
		//echoN($qac3PartLocationStr);
		$locationArr = preg_split("/\:/", $qac3PartLocationStr);
			
		//preprint_r($locationArr);
			
		$suraID =  $locationArr[0];
		
		$verseID =  $locationArr[1];
			
		$wordIndex =  $locationArr[2];
		
		return $MODEL_CORE['QURAN_TEXT'][($suraID-1)][($verseID-1)];
			
		
		
	}
	
	function  getWordIndexFromQACLocation($qac3PartLocationStr)
	{
		$locationArr = preg_split("/\:/", $qac3PartLocationStr);

			
		return  $locationArr[2];
	}
	
	function markSpecificWordInText($TEXT,$wordIndex,$charsToBeMarked,$markingTagName)
	{
		global $MODEL_CORE;
		
		$wordsArr = preg_split("/ /", $TEXT);
		
		//preprint_r($wordsArr);
		
		$wordsArr = removePauseMarksFromArr($MODEL_CORE['TOTALS']['PAUSEMARKS'],$wordsArr);
		
		
		
		$wordsArr[$wordIndex] = preg_replace("/(".$charsToBeMarked.")/mui", "<$markingTagName>\\1</$markingTagName>", $wordsArr[$wordIndex],1);
		
		//preprint_r($wordsArr);
		
		 $TEXT = implode(" ", $wordsArr);
		 
		 return $TEXT;
		 
		 //echoN($TEXT);
		 
		 //exit;
	}
	
	function getQACLocationStr($sura,$aya,$wordIndex)
	{
		return "$sura:$aya:$wordIndex";
	}
	
	function isDevEnviroment()
	{
		return ($_SERVER['REMOTE_ADDR']=="127.0.0.1" );
	}
	
	function removePauseMarksFromArr($pauseMarksArr,$targetArr)
	{

		$newArr = array();

	
	
			foreach($targetArr as $index => $value)
			{
				if ( !isset($pauseMarksArr[$value]) )
				{
					$newArr[]=$value;
				
				}
			
			}
	
		return $newArr;
	}
	
	
	function getImla2yWordIndexByUthmaniLocation($uthmaniQACLocation,$UTHMANI_TO_SIMPLE_LOCATION_MAP)
	{
		
		$locationArr = preg_split("/\:/", $uthmaniQACLocation);
		
		$suraAyaBaseLocation = $locationArr[0].":".$locationArr[1];
		
		$emla2tWordIndex = $UTHMANI_TO_SIMPLE_LOCATION_MAP[$suraAyaBaseLocation][($locationArr[2])];
			
		return  $emla2tWordIndex;
	}
	
	function getWordFromVerseByIndex($MODEL_CORE,$verseText, $oneBasedWordIndex)
	{
		$wordsArr = preg_split("/ /", $verseText);

		
		$wordsArr = removePauseMarksFromArr($MODEL_CORE['TOTALS']['PAUSEMARKS'],$wordsArr);
		
		
		return $wordsArr[$oneBasedWordIndex-1];
	}
	
	function handleDBError($sqliteDBObj)
	{
		$lastError = $sqliteDBObj->lastErrorCode();
		
		if ( $lastError!=0)
		{
			//UNIQUE constraint failed
			if ( $lastError=="19")
			{
				return "Error, data already in DB ! ";
			}
			else
			{
				return  "Error occurred [$lastError] ";
			}
			
		}
	}
	
	
	
?>