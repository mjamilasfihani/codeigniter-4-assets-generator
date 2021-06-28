<?php

namespace App\Libraries;

/**
 * Prototype
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
 * $theme->run(view('welcome_message'));
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

	protected $meta =
        [
                'description' => 'This is your website description (meta)',
                'keywords' => [],
                'author' => null,
                'viewport' => 'width=device-width, initial-scale=1, shrink-to-fit=no',

                'http-equiv' => [],
                'property' => []
        ];

	public function __construct(array $userCSS = [], array $userJS = [])
	{
                $app = config('App');

		if ($this->charset == null)
		{
			$this->charset = $app->charset;
		}

		if ($this->language == null)
		{
			$this->language = $app->defaultLocale;
		}

		if ($this->favicon == null)
		{
			$this->favicon = base_url('favicon.ico');
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

	protected function __header()
	{
		$str = doctype($this->doctype) . '<html lang="' . $this->language . '"> <head> <meta charset="' . $this->charset . '">';
		
                $_attrName = $this->filterMetaAttrName($this->meta);
                $_attrHttpEquiv = $this->meta['http-equiv'];
                $_attrProperty = $this->meta['property'];

		$str .= $this->generateMetaData();
		
		$str .= link_tag($this->favicon, 'icon', mime_content_type($this->favicon));
		
		if (empty($this->css) === false)
		{
			for ($i = 0; $i < count($this->css); $i++)
			{
				$str .= link_tag($this->css[$i]);
			}
		}

		if (empty($this->js) === false)
		{
			for ($i = 0; $i < count($this->js); $i++)
			{
				$str .= script_tag($this->js[$i]);
			}
		}

		if ($this->preload == true)
		{
			$str .= link_tag('https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.css') . script_tag('https://cdn.jsdelivr.net/gh/loadingio/ldLoader@v1.0.0/dist/ldld.min.js');
		}

		$str .= '<title>' . $this->title . '</title> </head> <body' . stringify_attributes($this->attributes) . '>';

		if ($this->preload == true)
		{
			$str .= '<div id="loader" class="ldld full"></div><script type="text/javascript">var ldld = new ldLoader({ root: "#loader" }); ldld.on();</script>';
		}

                return $str;
        }

        protected function __footer()
        {
		$str = '';

		if ($this->cookieBannerURI !== null)
		{
                        $str .= script_tag($this->cookieBannerURI);
		}

		if ($this->preload == true)
		{
			$str .= '<script type="text/javascript">ldld.off()</script>';
		}

		$str .= '</body> </html>';

		return $str;
	}

        protected function generateMetaData()
        {
                return;
        }

        protected function filterMetaAttrName($data)
        {
                unset($data['http-equiv'], $data['property']);
                return $data;
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
		$this->favicon = $config['favicon'] ?? $this->favicon;
	}

	public function meta(array $config = [])
	{
		$this->meta = array_merge($this->meta, $config);
	}

	public function run($view)
	{
		return $this->__header() . $view . $this->__footer();
	}

}
