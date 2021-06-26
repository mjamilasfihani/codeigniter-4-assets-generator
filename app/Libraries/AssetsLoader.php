<?php

namespace App\Libraries;

/**
 * General Prototype
 *
 * $css = [];
 * $js = [];
 *
 * $theme = new App\Libraries\AssetsLoader($css, $js);
 *
 * $bodyConfig =
 * [
 * 		'attributes' => [],
 *		'preload' => true,
 *		'cookieBannerURI' => null
 * ];
 *
 * $htmlConfig =
 * [
 * 		'doctype' => 'html5',
 *		'charset' => null,
 *		'language' => null,
 *		'title' => 'Your Website Title',
 *		'favicon' => null
 * ];
 *
 * $metaConfig =
 * [
 * 		'description' => 'This is your website description (meta)',
 *		'keywords' => [],
 *		'author' => null,
 *		'viewport' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
 *
 *		// @start add another meta with 'name' attribute
 *
 *		// @end
 *
 *		'http-equiv' => [], // this is meta with 'http-equiv' attribute
 *		'property' => []  // this is meta with 'property' attribute
 * ];
 *
 * $theme->body($bodyConfig);
 * $theme->html($htmlConfig);
 * $theme->meta($metaConfig);
 *
 * $theme->run();
 *
 */

class AssetsLoader
{

	protected $css = [];
	protected $js = [];

	protected $attributes = [];
	protected $preload = true;
	protected $cookieBannerURI = null;

	protected $doctype = 'html5';
	protected $charset = null;
	protected $language = null;
	protected $title = 'Your Website Title';
	protected $favicon = null;

	protected $meta = [];

	// constructing the assets first
	public function __construct(array $userCSS = [], array $userJS = [])
	{
		helper('html');

		if (is_null($this->charset))
		{
			$this->charset = config('App')->charset;
		}

		if (is_null($this->language))
		{
			$this->language = config('App')->defaultLocale;
		}

		if (is_null($this->favicon))
		{
			$this->favicon = link_tag(base_url('favicon.ico'), 'icon', 'image/ico');
		}

		$defaultCSS =
		[
			'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.css',
			'https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.14.0/css/all.css'
		];

		$defaultJS =
		[
			'https://cdn.jsdelivr.net/npm/jquery@3.3.1/dist/jquery.js',
			'https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/popper.js',
			'https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.js'
		];

		$this->css = empty($userCSS) ? $defaultCSS : $userCSS;
		$this->js = empty($userJS) ? $defaultJS : $userJS;
	}

	protected function header()
	{
		$str  = doctype($this->doctype);
		$str .= '<html lang="' . $this->language . '">';
		$str .= '<head>';
		$str .= '<meta charset="' . $this->charset . '">';
		
		// meta
		
		$str .= $this->favicon;
		
		// css
		if (! empty($this->css))
		{
			for ($i=0; $i <count($this->css); $i++)
			{
				$str .= link_tag($this->css[$i]);
			}
		}

		// js
		if (! empty($this->js))
		{
			for ($i=0; $i < count($this->js) ; $i++)
			{
				$str .= script_tag($this->js[$i]);
			}
		}

		if ($this->preload)
		{
			$str .= link_tag('https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.css');
			$str .= script_tag('https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.js');
		}

		$str .= '<title>' . $this->title . '</title>';
		$str .= '</head>';
		$str .= '<body ' . stringify_attributes($this->attributes) . '>';

		if ($this->preload)
		{
			$str .= '<div id="loader" class="ldld full"></div><script type="text/javascript">var ldld = new ldLoader({ root: "#loader" }); ldld.on();</script>';
		}

		return $str;
	}

	protected function footer()
	{
		$str  = '';

		if (! is_null($this->cookieBannerURI))
		{
			$str .= '<script type="text/javascript" src="'.$this->cookieBannerURI.'"></script>';
		}

		if ($this->preload)
		{
			$str .= '<script type="text/javascript">ldld.off()</script>';
		}

		$str .= '</body>';
		$str .= '</html>';

		return $str;
	}

	public function body(array $config = [])
	{
		$this->attributes = $config['attributes'] ?? $this->attributes;
		$this->preload = $config['preload'] ?? $this->preload;
		$this->cookieBannerURI = $config['cookieBannerURI'] ?? $this->cookieBannerURI;
	}

	public function html(array $config = [])
	{
		$this->doctype = $config['doctype'] ?? $this->doctype;
		$this->charset = $config['charset'] ?? $this->charset;
		$this->language = $config['language'] ?? $this->language;
		$this->title = $config['title'] ?? $this->title;
		$this->favicon = link_tag($config['favicon'], 'icon', mime_content_type($config['favicon'])) ?? $this->favicon;
	}

	public function meta(array $config = [])
	{
		$this->meta = array_merge($this->meta, $config);
	}

	public function run($view)
	{
		$parser = single_service('parser');

		return $parser->renderString($this->header()) . $view . $parser->renderString($this->footer());
	}

}