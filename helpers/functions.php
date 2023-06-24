<?php 

	class AllFunctions {
		private $front = 'CKTUTAS/TEIN/';
		
		public function generate_identity_number($id) {
			$thisYr = date("y");
			$thisYr = substr($thisYr, -2);
			return ($this->front . str_pad($id, 5, "0", STR_PAD_LEFT) . '/' . $thisYr);
		}
	}

