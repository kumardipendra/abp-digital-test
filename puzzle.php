<?php
ini_set('memory_limit', '-1');
/**
 * set memory limit 0 since large amount of data
 * PHP version 5.5.X
 * Current directory should be writable so that output.txt file should be create and can write.
 *
 * @package    abp-digital-assingment
 * @author     Dipendra Kumar <dipendra.kumar2@gmail.com>
 * @version    TBD
 */
class Puzzle{ 
	/**
     * Class Puzzle
     *
     * input the file name in class to process
     *
     * @var $fileName
     */
	public $fileName;

	function __construct($text){
		$this->fileName = $text;
	}

	/**
     * function assignWines
     *
     * input the file which contain the person and wine data, output a TSV file which contain the desired result based on puzzle.
     *
     */
	public function assignWines(){
		$winewishlist	= [];
		$winesold 		= 0;
		$finalList 		= [];
		$file 			= fopen($this->fileName,"r");
		while (($line = fgets($file)) !== false) {
			$nameandwine = explode("\t", $line);
			$name = trim($nameandwine[0]);
			$wine = trim($nameandwine[1]);
			if(!array_key_exists($wine, $winewishlist)){
				$winewishlist[$wine] = [];
			}
			$winewishlist[$wine][] = $name;
			$wineList[] = $wine;
		}
		fclose($file);
		$wineList = array_unique($wineList);
		foreach ($wineList as $key => $wine) {
			$maxSize = count($wine);
			$counter = 0;

			while($counter<10){
				$i = intval(floatval(rand()/(float)getrandmax()) * $maxSize);
				$person = $winewishlist[$wine][$i];
				if(!array_key_exists($person, $finalList)){
					$finalList[$person] = [];
				}
				if(count($finalList[$person])<3){
					$finalList[$person][] = $wine;
					$winesold++;
					break;
				}
				$counter++;
			}
		}

		$fh = fopen("output.txt", "w");
		fwrite($fh, "Total number of wine bottles sold in aggregate : ".$winesold."\n");
		foreach (array_keys($finalList) as $key => $person) {
			foreach ($finalList[$person] as $key => $wine) {
				fwrite($fh, $person." ".$wine."\n");
			}
		}
		fclose($fh);
	}
}
echo "Started at : ".date('Y-m-d H:i:s')."\n";
echo "<br>";
$puzzle = new Puzzle("person_wine_3.txt");
$puzzle->assignWines();
echo "Stoped at : ".date('Y-m-d H:i:s')."\n";
echo "<br>";
echo "Please open output.txt to view the output";
?>
