<?php

/**
 * MIT License
 *
 * Copyright (c) 2021 Mohammad Jamil Asfihani
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace App\Libraries;

/**
 * Prototype
 *
 * $css = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.css'];
 * $js = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.js'];
 * $jquery = 'https://code.jquery.com/jquery-3.6.0.min.js';
 *
 * $template = new App\Libraries\AssetsLoader($css, $js, $jquery);
 *
 * $body =
 * [
 * 		'attributes' => [],
 *		'preload' => false,
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
 *		'author' => '',
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
 */

class AssetsLoader
{

	/**
	 * Default CSS
	 *
	 * The default CSS is using Bootsrap v5,
	 * visit https://getbootstrap.com for more information.
	 *
	 * @var array
	 */
	protected $css = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.css'];

	/**
	 * Default JS
	 *
	 * The default JS is using Bootstrap v5,
	 * visit https://getbootstrap.com for more information.
	 *
	 * @var array
	 */
	protected $js = ['https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.js'];

	/**
	 * Default jQuery
	 *
	 * jQuery is need for preloader to work correctly, we use
	 * v3.6.0 and min version.
	 *
	 * @var string
	 */
	protected $jquery = 'https://code.jquery.com/jquery-3.6.0.min.js';

	/**
	 * --------------------------------------------------------------------------
	 * Body Attributes
	 * --------------------------------------------------------------------------
	 *
	 * If you have some tag body attributes, you can add it here.
	 *
	 * Prototype
	 *
	 *   $attributes = [
	 *   	  'class' => 'landing-page',
	 *		  'id'    => 'welcome'
	 *   ];
	 *
	 *   $template->body(['attributes' => $attributes]);
	 *
	 * It will be
	 *
	 *   <body class="landing-page" id="welcome">
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * --------------------------------------------------------------------------
	 * PreLoad Page
	 * --------------------------------------------------------------------------
	 *
	 * If you dont want use preloader screen, set to false. The default is true
	 *
	 * This preload is using LoadingIo library,
	 * visit https://loading.io for more information.
	 *
	 * @var bool
	 */
	protected $preload = false;

	/**
	 * --------------------------------------------------------------------------
	 * Cookie Banner
	 * --------------------------------------------------------------------------
	 *
	 * If you need a cookie banner, feel free to set a value at here.
	 * This library cookie banner is using Cookie-Script.Com (suggestion).
	 *
	 * Parameter is https://cdn.cookie-script.com/s/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.js
	 * or just copy your js url and paste in here (because Cookie-Script has GEO features).
	 *
	 * If your website isn't have the quality to use cookie, leave it blank.
	 *
	 * @var string
	 */
	protected $cookieBannerURI = null;

	/**
	 * --------------------------------------------------------------------------
	 * Doctype Declaration
	 * --------------------------------------------------------------------------
	 *
	 * All HTML documents must start with a <!DOCTYPE> declaration.
	 * The declaration is not an HTML tag. It is an "information" to the browser
	 * about what document type to expect. - W3SCHOOLS.COM
	 *
	 * The default value is 'html5' but you can fill it based on your needed.
	 * See the available list in CodeIgniter userguide.
	 *
	 * @var string
	 */
	protected $doctype = 'html5';

	/**
	 * --------------------------------------------------------------------------
	 * Meta Charset
	 * --------------------------------------------------------------------------
	 *
	 * To display an HTML page correctly, a web browser must know the character
	 * set used in the page. - W3SCHOOLS.COM
	 *
	 * In modern browser or HTML5 the default charset is UTF-8, if you have
	 * another option it's up to you. Leave it blank it will use charset from
	 * app/Config/App.php
	 *
	 * @var string
	 */
	protected $charset = null;

	/**
	 * --------------------------------------------------------------------------
	 * Page Language
	 * --------------------------------------------------------------------------
	 *
	 * You should always include the lang attribute inside the <html> tag,
	 * to declare the language of the Web page. This is meant to assist
	 * search engines and browsers. - W3SCHOOLS.COM
	 *
	 * You could set this variable as you want. Leave it blank it will use
	 * defaultLocale from app/Config/App.php
	 *
	 * @var string
	 */
	protected $language = null;

	/**
	 * --------------------------------------------------------------------------
	 * Web Title
	 * --------------------------------------------------------------------------
	 *
	 * The contents of a page title is very important for search engine
	 * optimization (SEO)! The page title is used by search engine algorithms to
	 * decide the order when listing pages in search results. - W3SCHOOLS.COM
	 *
	 * @var string
	 */
	protected $title = 'Your Website Title';

	/**
	 * --------------------------------------------------------------------------
	 * Favicon
	 * --------------------------------------------------------------------------
	 *
	 * Leave it blank it will use default protocol base_url('favicon.ico') or
	 * fill it with your own link and the type attribute will auto detect.
	 *
	 * @var string
	 */
	protected $favicon = null;

	/**
	 * --------------------------------------------------------------------------
	 * Meta
	 * --------------------------------------------------------------------------
	 *
	 * If you have your own meta put it here. There is 3 types attribute of meta : name,
	 * http-equiv and property.
	 *
	 * This config will generate
	 *
	 *   name attribute       --> <meta name="name" content="..." />
	 *   http-equiv attribute --> <meta http-equiv="name" content="..."/>
	 *   property attribute   --> <meta property="name" content="..."/>
	 *
	 * @see https://gist.github.com/lancejpollard/1978404
	 * @var array
	 */
	protected $meta =
	[
		'description' => 'This is your website description (meta)',
		'keywords' => [],
		'author' => '',
		'viewport' => 'width=device-width, initial-scale=1, shrink-to-fit=no',

		'http-equiv' => [],
		'property' => []
	];

	/**
	 * Constructor
	 *
	 * @param array $css []
	 * @param array $js  []
	 */
	public function __construct(array $css = [], array $js = [], string $jquery = null)
	{
		// Load the config from app/Config/App.php
		$app = config('App');

		// Set the config of charset
		if ($this->charset == null)
		{
			$this->charset = $app->charset;
		}

		// Set the config of language
		if ($this->language == null)
		{
			$this->language = $app->defaultLocale;
		}

		// Set the config of favicon
		if ($this->favicon == null)
		{
			$this->favicon = base_url('favicon.ico');
		}

		// Set the config of CSS
		if (empty($css) === false)
		{
			$this->css = $css;
		}

		// Set the config of JS
		if (empty($js) === false)
		{
			$this->js = $js;
		}

		// Set the jQuery
		if ($jquery !== null)
		{
			$this->jquery = $jquery;
		}
	}

	/**
	 * Header section
	 *
	 * @return string
	 */
	protected function __header()
	{
		$str = doctype($this->doctype) . '<html lang="' . $this->language . '"><head><meta charset="' . $this->charset . '">';

		if (empty($this->_metaFilterName($this->meta)) === false)
		{
			foreach ($this->_metaFilterName($this->meta) as $name => $value)
			{
				$str .= $this->_metaTagGenerator($name, $value);
			}
		}

		if (empty($this->meta['http-equiv']) === false)
		{
			foreach ($this->meta['http-equiv'] as $name => $value)
			{
				$str .= $this->_metaTagGenerator($name, $value, 'http-equiv');
			}
		}

		if (empty($this->meta['property']) === false)
		{
			foreach ($this->meta['property'] as $name => $value)
			{
				$str .= $this->_metaTagGenerator($name, $value, 'property');
			}
		}

		$str .= link_tag($this->favicon, 'icon', mime_content_type(basename($this->favicon)));
		
		if (empty($this->css) === false)
		{
			for ($i = 0; $i < count($this->css); $i++)
			{
				$str .= link_tag($this->css[$i]);
			}
		}

		if ($this->preload == true)
		{
			$str .= script_tag($this->jquery);
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
			$str .= '<style type="text/css"> .preloader {position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: 9999; background-color: #fff; } .loading {position: absolute; left: 50%; top: 50%; transform: translate(-50%,-50%); font: 14px arial; } </style>';
		}

		$str .= '<title>' . $this->title . '</title></head><body' . stringify_attributes($this->attributes) . '>';

		if ($this->preload == true)
		{
			$str .= '<div class="preloader"> <div class="loading"> <img src="..." width="86"> <p style="font-size: 1.0rem">Please Wait</p> </div> </div>';
		}

		return $str;
	}

	/**
	 * Footer section
	 *
	 * @return string
	 */
	protected function __footer()
	{
		$str = '';

		if ($this->cookieBannerURI !== null)
		{
			$str .= script_tag($this->cookieBannerURI);
		}

		if ($this->preload == true)
		{
			$str .= '<script type="text/javascript">$(document).ready(function(){$(".preloader").fadeOut(); })</script>';
		}

		$str .= '</body></html>';

		return $str;
	}

	//--------------------------------------------------------------------

	/**
	 * Generating Meta Data
	 *
	 * @param  string $name
	 * @param  string $content
	 * @param  string $type
	 * @return string
	 */
	protected function _metaTagGenerator(string $name = '', string $content = '', string $type = 'name')
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

	/**
	 * Filter the Meta Data
	 *
	 * Remove the meta http-equiv and property,
	 * and implode the meta keywords.
	 *
	 * @param  array $meta
	 * @return array
	 */
	protected function _metaFilterName(array $meta = [])
	{
		unset($meta['http-equiv'], $meta['property']);

		$meta['keywords'] = implode(', ', $meta['keywords']);

		return $meta;
	}

	//--------------------------------------------------------------------

	/**
	 * Body
	 *
	 * @param array $config
	 */
	public function body(array $config = [])
	{
		$this->attributes = $config['attributes'] ?? $this->attributes;
		$this->preload = $config['preload'] ?? $this->preload;
		$this->cookieBannerURI = $config['cookieBannerURI'] ?? $this->cookieBannerURI;
	}

	/**
	 * Html
	 *
	 * @param array $config
	 */
	public function html(array $config = [])
	{
		$this->doctype = $config['doctype'] ?? $this->doctype;
		$this->charset = $config['charset'] ?? $this->charset;
		$this->language = $config['language'] ?? $this->language;
		$this->title = $config['title'] ?? $this->title;
		$this->favicon = $config['favicon'] ?? $this->favicon;
	}

	/**
	 * Meta
	 *
	 * @param array $config
	 */
	public function meta(array $config = [])
	{
		$this->meta = array_merge($this->meta, $config);
	}

	//--------------------------------------------------------------------

	/**
	 * Render
	 *
	 * @param  string $view
	 * @return string
	 */
	public function render($view)
	{
		return $this->__header() . $view . $this->__footer();
	}

}
