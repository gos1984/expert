<?php
namespace core;

abstract class View {

	public abstract function output($action, $data = null);
}

?>