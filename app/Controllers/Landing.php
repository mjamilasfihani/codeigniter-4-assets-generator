<?php

namespace App\Controllers;

class Landing extends BaseController
{

	public function index()
	{
		return $this->__render('_landing_message', ['text' => 'Coming Soon']);
	}

	//--------------------------------------------------------------------

	protected function __render(string $name = '', array $data = [], array $options = [])
	{
		// Load the html helper
		helper('html');

		// Calling the library
		$template = new \App\Libraries\AssetsLoader();

		// Render it
		return $template->render(view($name, $data, $options));
	}

}
