<?php

namespace App\Controllers;

class Example extends BaseController
{

	public function index()
	{
		return $this->__render(view('example_message', ['text' => 'Coming Soon']));
	}

	//--------------------------------------------------------------------

	protected function __render($view)
	{
		// Load the html helper
		helper('html');

		// Calling the library
		$template = new \App\Libraries\AssetsLoader();

		// Return it
		return $template->render($view);
	}

}
