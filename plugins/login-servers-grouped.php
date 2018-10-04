<?php

/** Display constant list of servers in login form
 * @link https://www.adminer.org/plugins/#use
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Charles Peterson https://github.com/Artistan
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class AdminerLoginServersGrouped {
	/** @access protected */
	var $servers;
	var $names;

	/** Set supported servers
	 * @param array array($group => array($description => array("server" => , "driver" => "server|pgsql|sqlite|...")))
	 * @param boolean
	 */
	function __construct($servers) {
		$this->servers = [];
		$this->names = [];
		array_map(function($elements,$key){
			// merge the opt groups into a list of servers
			$this->servers = array_replace($this->servers, $elements);
			// simplify the server list for optionslist() function
			$this->names[$key] = array_keys($elements);
		},$servers,array_keys($servers));
		if ($_POST["auth"]) {
			$key = $_POST["auth"]["server"];
			$_POST["auth"]["driver"] = $this->servers[$key]["driver"];
		}
	}

	function credentials() {
		return array($this->servers[SERVER]["server"], $_GET["username"], get_password());
	}

	function login($login, $password) {
		if (!$this->names[SERVER]) {
			return false;
		}
	}

	function loginFormField($name, $heading, $value) {
		if ($name == 'driver') {
			return '';
		} elseif ($name == 'server') {
			//	var_dump($this->names);exit;
			return $heading . "<select name='auth[server]'>" . optionlist($this->names, SERVER) . "</select>\n";
		}
	}

}
