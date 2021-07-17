<?php

namespace App\Controllers;

class Landing extends BaseController
{
	public function index()
	{
		return self::render('_landing_message', ['text' => 'Coming Soon']);
	}

	//--------------------------------------------------------------------

	protected static function render(string $name = '', array $data = [], array $options = [])
	{
		// Load the html helper
		helper('html');

		// Calling the library
		$template = new \App\Libraries\AssetsLoader();

		// A little conguration
		$template->body(['preload' => true]);
		$template->html(['title' => 'Coming Soon']);
		$template->meta(['description' => 'Thank you for visiting our website, currently this website is coming soon.']);

		// Render it
		return $template->render(view($name, $data, $options));
	}
}