<?php
class ClassLoader{

		/**
		 *
		 * ディレクトリ格納
		 * @var unknown_type
		 */
		private $dirs = array();

		/**
		 *
		 * コンストラクタ
		 */
		public function __construct() {
				spl_autoload_register(array($this, 'loader'));
		}

		/**
		 *
		 * ディレクトリを登録
		 * @param string $dir
		 */
		public function registerDir($dir){
				$this->dirs[] = $dir;
		}

		/**
		 *
		 * コールバック
		 * @param string $classname
		 */
		public function loader($classname){

				foreach ($this->dirs as $dir) {

						$file = $dir . '/' .  $classname . '.php';
						if(is_readable($file)){
								require $file;
								return;
						}
				}
		}
}