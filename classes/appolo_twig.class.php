<?php

/**
 *
 * @package		appolo
 * @subpackage	dgjolero
 * @author	João Guilherme <joaoguilherme@guiatech.com.br>
 */

class appolo_twig extends appolo {

	public $site_config_staging ;
	public $site_view_staging ;
	public $site_config_prod ;
	public $site_view_prod ;

	public function appolo_twig(){ /*__construct*/

		/*main*/

	}

	public function set_site_configs( $site_config_staging, $site_config_prod, $site_view_staging, $site_view_prod ) {
		$this->site_config_staging = $site_config_staging ;
		$this->site_view_staging = $site_view_staging ;
		$this->site_config_prod = $site_config_prod ;
		$this->site_view_prod = $site_view_prod ;
	}

	public function get_site_config_staging() {
		return $this->site_config_staging ;
	}

	public function get_site_view_staging() {
		return $this->site_view_staging ;
	}

	public function get_site_config_prod() {
		return $this->site_config_prod ;
	}

	public function get_site_view_prod() {
		return $this->site_view_prod ;
	}
		public function get_site_config() {
	return $this->site_config_staging ;
	}

}

?>