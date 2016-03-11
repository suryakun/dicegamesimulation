<?php
	
	/*
		Game test
		Author; Surya Surakhman
		date: 11-03-2016
	*/

	/**
	* Dice Class
	*/
	class Dice
	{

		public $players = ['A','B','C','D'];

		public function getDices()
		{
			$dices = [];
			for ($k=0; $k < count($this->players); $k++) { 
				for ($i=0; $i < 6 ; $i++) { 
					$dices[$k][$i] = rand(1,6);
				}
			}
			return $dices;
		}
	}


	/**
	* Round Class
	*/
	class Rules
	{

		public $winner = array();

		public function checkWinner($array, $index)
		{
			if (count($array) == 0) {
				array_push($this->winner, $index);
			}
		}

		public function filteringSix($array=[])
		{
			$keysix = array_keys($array);
			foreach ($keysix as $key6) {
				if ($array[$key6] === 6) {
					unset($array[$key6]);
				}
			}
			return $array;
		}

		public function filteringOne($array=[])
		{
			$counterOne = 0;
			$keys = array_keys($array);
			foreach ($keys as $key) {
				if ($array[$key] === 1) {
					unset($array[$key]);
					$counterOne++;
				}
			}
			$filteredOne['array'] = $array;
			$filteredOne['coutedOne'] = $counterOne;
			return $filteredOne;
		}

		public function passingOne($array=array(), $index=0, $repeat=0)
		{
			for ($n=0; $n < $repeat; $n++) { 
				array_push($array, 1);
			}
			return $array;
		}

		public function shakingTheDice()
		{
			$dice = new Dice();
			$round = 1;
			while (count($this->winner) == 0) {
				$filteredSix = array();
				$dices = $dice->getDices();
				echo "====================== Round ". $round . " =======================================". PHP_EOL;
				for ($l=0; $l < count($dice->players); $l++) { 
					$dices[$l] = $this->filteringSix($dices[$l]);
					$removeOne = $this->filteringOne($dices[$l]);

					$dices[$l] = $removeOne['array'];
					$destPass = ($l ==  count($dice->players) - 1) ? 0 : $l+1;

					if ($removeOne['coutedOne'] > 0) {
						$this->passingOne($dices[$l], $l, $removeOne['coutedOne']);
					}

					$this->checkWinner($dices[$l], $l);

					echo "Player ". $dice->players[$l]. " has dices". PHP_EOL;
					print_r($dices[$l]);
				}
				$round++;
			}
			
			echo "The winner Is". PHP_EOL;
			foreach ($this->winner as $win) {
				echo "Player ". $dice->players[$win] . PHP_EOL;
			}
			echo "YEAAY Congratulation ...\(^0^)/". PHP_EOL;
		}
	}

	$rules = new Rules();
	$rules->shakingTheDice();

?>
