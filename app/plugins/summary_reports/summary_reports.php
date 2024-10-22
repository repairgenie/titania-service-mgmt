<?php
	include(__DIR__ . '/../plugins-resources/loader.php');

	class summary_reports extends AppGiniPlugin {
		/* add any plugin-specific properties here */
		// if left empty, no logging
		private $logFile = '';
		
		public function __construct($config = []) {
			parent::__construct($config);
			
			/* add any further plugin-specific initialization here */
		}
		
		/**
			@param $tn string, name of table
			@param $fn string, name of field
			@return integer 0-based index (acording to project order) of given field in given table if the field is a lookup, -1 otherwise
		*/
		function lookup_field_index($tn, $fn) {
			$field = $this->field($tn, $fn);
			if($field === false) return -1; // table/field name not found

			$pt = (string) $field->parentTable;
			if(!$pt) return -1; // not a lookup field

			return $this->field_index($tn, $fn);
		}

		/**
		 * Add entry to log file
		 *
		 * @param      object  $msg    The object to log
		 * @param      boolean $clear  Overwrite log file if true
		 */
		function log($msg, $clear = false) {
			if(!$this->logFile) return;
			
			ob_start();
			print_r([
				'timestamp' => time(),
				'time' => date('H:i:s'),
				'msg' => $msg
			]);

			file_put_contents(
				$this->logFile, 
				ob_get_clean() . "\n", 
				$clear ? 0 : FILE_APPEND
			);
		}
	}
