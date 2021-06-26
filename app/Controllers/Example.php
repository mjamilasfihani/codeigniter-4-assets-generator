<?php

namespace App\Controllers;

class Example extends BaseController
{

	public function index()
	{
		return $this->__(view('example_message', ['text' => 'Coming Soon']));
	}

	//--------------------------------------------------------------------

	protected function __($view)
	{
		$theme = new \App\Libraries\AssetsLoader();

		return $theme->run($view);
	}

}
