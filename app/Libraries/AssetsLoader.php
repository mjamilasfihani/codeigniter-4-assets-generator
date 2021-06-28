<?php

namespace App\Libraries;

/**
 * Prototype
 *
 * $css = [];
 * $js = [];
 *
 * $template = new App\Libraries\AssetsLoader($css, $js);
 *
 * $body =
 * [
 * 		'attributes' => [],
 *		'preload' => true,
 *		'cookieBannerURI' => null
 * ];
 *
 * $html =
 * [
 * 		'doctype' => 'html5',
 *		'charset' => null,
 *		'language' => null,
 *		'title' => 'Your Website Title',
 *		'favicon' => null
 * ];
 *
 * $meta =
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
 * $template->body($body);
 * $template->html($html);
 * $template->meta($meta);
 *
 * $template->render(view('welcome_message'));
 *
 */

// Credits :
// - css & js by Bootstrap
// - Preload by loading.io

class AssetsLoader
{

	protected $css = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css'];
	protected $js = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js'];

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

	public function __construct(array $css = [], array $js = [])
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

                if (empty($css) === false)
                {
                        $this->css = $css;
                }

                if (empty($js) === false)
                {
                        $this->js = $js;
                }
	}

	protected function __header()
	{
		$str = doctype($this->doctype) . '<html lang="' . $this->language . '"> <head> <meta charset="' . $this->charset . '">';
		
	        if (empty($this->filterMetaAttrName($this->meta)) === false)
		{
			foreach ($this->filterMetaAttrName($this->meta) as $name => $value)
			{
				$str .= $this->generateMetaData($name, $value);
			}
		}

                if (empty($this->meta['http-equiv']) === false)
		{
			foreach ($this->meta['http-equiv'] as $name => $value)
			{
				$str .= $this->generateMetaData($name, $value, 'http-equiv');
			}
		}

                if (empty($this->meta['property']) === false)
		{
			foreach ($this->meta['property'] as $name => $value)
			{
				$str .= $this->generateMetaData($name, $value, 'property');
			}
		}

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

        protected function generateMetaData(string $name = '', string $content = '', string $type = 'name')
        {
		$str = '';
						
		foreach ([['name' => $name, 'content' => $content, 'type' => $type]] as $val)
		{
			$type	 = empty($val['type'])    ? '' : $val['type'];
			$name	 = empty($val['name'])    ? '' : $val['name'];
			$content = empty($val['content']) ? '' : $val['content'];

			$str .= '<meta '.$type.'="'.$name.'" content="'.$content.'" />';
		}

		return $str;
        }

        protected function filterMetaAttrName($data)
        {
                unset($data['http-equiv'], $data['property']);

                $data['keywords'] = implode(', ', $data['keywords']);

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

	public function render($view)
	{
		return $this->__header() . $view . $this->__footer();
	}

}
