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

		// A little Body conguration
		$template->body([
			'attributes' => ['id' => 'landing-page'],
			'preload' => true
		]);

		// A little Html configuration
		$template->html([
			'language' => 'en',
			'title' => 'Coming Soon'
		]);

		// A little Meta configuration
		$template->meta([
			'author' => 'Website Developer',
			'description' => 'Thank you for visiting our website, currently this website is coming soon.'
		]);

		// Render it
		return $template->render(view($name, $data, $options));
	}

}
