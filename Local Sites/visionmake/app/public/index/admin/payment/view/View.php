<?php

class View {

	protected $template_dir = null;
	protected $template = null;
	protected $context = array();

	function __construct($DIR = null){
		$directory = dirname($DIR) ;
		$filename = basename($DIR, '.php') . '.tpl';
		$this->set_dir($directory);
		$this->set_template($filename);
	}

	function set_template($filename){
		$this->template = $filename;
	}

	function set_dir($directory){
		if(substr($directory, -1) != '/') $directory .= '/';
		$this->template_dir = $directory;
	}

	function assign($context_key, $context_data, $overwrite = false){
		if(empty($this->context[$context_key]) || $overwrite){
			$this->context[$context_key] = $context_data;
		}else{
			if(is_array($context_data) && is_array($this->context[$context_key])){
				$this->context[$context_key] = array_merge($this->context[$context_key], $context_data);
			}else{
				$this->context[$context_key] .= $context_data;
			}
		}
	}

	function reset($context_key = null){
		if(is_null($context_key)){
			$this->context = array();
		}else{
			$this->context[$context_key] = null;
		}
	}

	function convert_template(){
		$filename = $this->template_dir.$this->template;
		$cachename = $filename.'.cache';
		if(!file_exists($cachename) || filemtime($cachename) < filemtime($filename)){
			$s = file_get_contents($filename);
			$s = $this->convert_string($s);

			if(is_writable($cachename) || is_writable($this->template_dir)){
				file_put_contents($cachename, $s);
			}
		}
		return $cachename;
	}

	function convert_string($s) {
		$s = preg_replace('/#\{(.*?)\}/', '<?php echo $1; ?>', $s);
		$s = preg_replace('/%\{(.*?)\}/', '<?php echo htmlspecialchars($1,ENT_QUOTES); ?>', $s);
		return $s;
	}

	function display(){

		if ( VIEW_CACHE == TRUE) {
			extract($this->context);
			ob_start();
			$cachename = $this->template_dir.$this->template.'.cache';
			include($cachename);
			$body = ob_get_contents();
			ob_end_clean();
			echo $body;

		} else {
			$cache = $this->convert_template();
			extract($this->context);
			include($cache);
		}
	}

	function lock_file_put_contents($fname, $data) {
		if ($fp = fopen($fname, 'c')) {
			flock($fp, LOCK_EX);
			ftruncate($fp, 0);
			fputs($fp, $data);
			fclose($fp);
		}
		return (bool)$fp;
	}

	function lock_file_get_contents($fname) {
		if ($fp = fopen($fname, 'c')) {
			flock($fp, LOCK_EX);
			$buf = '';
			while ($get = fgets($fp, 1024)) $buf .= $get;
			fclose($fp);
			return $buf;
		} else {
			return false;
		}
	}
}
?>