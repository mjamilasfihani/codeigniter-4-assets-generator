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
                helper('html');

		$theme = new \App\Libraries\AssetsLoader();

		return $theme->run($view);
	}

}
