<?

namespace Impro\Event
{
	class Poster extends \System\Model\Attr
	{
		const DIR_TMP = '/var/tmp/posters';
		const SIZE_DEFAULT = '1571x2222';
		const SIZE_BORDER  = 30;
		const SIZE_FOOTER_ITEMS = 300;
		const TEXT_VS = '  vs  ';

		const SHADOW_SIZE = 25;
		const SHADOW_FUZZ = 5;

		const TEXT_ALIGN_LEFT   = 1;
		const TEXT_ALIGN_RIGHT  = 2;
		const TEXT_ALIGN_CENTER = 3;

		const LOGO_HEIGHT = 300;

		protected static $attrs = array(
			"event"  => array('object', "model" => 'Impro\Event'),
			"ren"    => array('object', "model" => 'System\Template\Renderer'),
			"width"  => array('int', "is_unsigned" => true),
			"height" => array('int', "is_unsigned" => true),
			"output" => array('string'),
		);


		private static $fonts = array(
			'biolinum' => array(
				"regular" => array(
					"path" => '/share/fonts/biolinum/regular.ttf',
				),
				"bold"    => array(
					"path" => '/share/fonts/biolinum/bold.ttf',
				),
			)
		);


		private static $elements = array(
			"header" => array(
				'x' => 400,
				'y' => 50,
			),
		);


		private static $texts = array(
			"header" => array(
				"line-height" => 100,
				"font-size"   => 85,
				"font-family" => 'biolinum',
				"font-weight" => 'bold',
				"color"       => 'white',
				"x" => 480,
				"y" => 200,
				"angle" => 6,
				"content" => array(
					'ZÁPAS V IMPROVIZACI',
					'na vaše témata',
				)
			),

			"versus" => array(
				"line-height" => 150,
				"font-size"   => 90,
				"font-family" => 'biolinum',
				"font-weight" => 'bold',
				"text-align"  => self::TEXT_ALIGN_CENTER,
				"color"       => 'white',
				"y" => 575,
				"angle" => 0,
			),
			"cities" => array(
				"line-height" => 150,
				"font-size"   => 50,
				"font-family" => 'biolinum',
				"font-weight" => 'regular',
				"text-align"  => self::TEXT_ALIGN_CENTER,
				"color"       => 'white',
				"angle" => 0,
			),
			"location" => array(
				"line-height" => 75,
				"font-size"   => 60,
				"font-family" => 'biolinum',
				"font-weight" => 'regular',
				"color"       => 'white',
				"text-align"  => self::TEXT_ALIGN_RIGHT,
				"angle" => 0,
				"x"     => 1450,
				"y"     => 1200,
			),
			"footer" => array(
				"line-height" => 30,
				"font-size"   => 30,
				"font-family" => 'biolinum',
				"font-weight" => 'regular',
				"color"       => 'white',
				"angle" => 0,
				"x"     => 500,
				"y"     => 500,
			),
		);

		private $canvas;
		private $colors = array();


		public static function generate(\System\Template\Renderer $ren, \Impro\Event $e, $size=self::SIZE_DEFAULT)
		{
			$size = explode('x', $size);
			$poster = new self(array(
				"ren"    => $ren,
				"event"  => $e,
				"width"  => $size[0],
				"height" => $size[1],
			));

			return $poster
				->allocate_colors()
				->create_canvas()
				->draw_background()
				->draw_header()
				->draw_team_names()
				->draw_location()
				->draw_footer()
				->save();
		}


		private function color($name)
		{
			if (isset($this->colors[$name])) {
				return $this->colors[$name];
			} else {
				return new \ImagickPixel($name);
			}
		}


		private function create_canvas()
		{
			$this->canvas = new \Imagick();
			$this->canvas->newImage($this->width, $this->height, $this->color('back'));
			$this->canvas->setFormat('png');
			return $this;
		}


		private function allocate_colors()
		{
			$this
				->allocate_color('white', '#fff')
				->allocate_color('black', '#000')
				->allocate_color('rtc', '#193d5f')
				->allocate_color('lbc', '#301110')
				->allocate_color('rtc', '#F7FA3E')
				->allocate_color('lbc', '#51110F')
				->allocate_color('back', '#000');
			return $this;
		}


		private function allocate_color($name, $color)
		{
			$this->colors[$name] = $color;
			return $this;
		}


		private function draw_background()
		{
			return $this
				->draw_background_gradients()
				->draw_lightray()
				->draw_border();
		}


		private function draw_background_gradients()
		{
			$helper = new \Imagick();
			$helper->newPseudoImage(round($this->width*1.7), round($this->height*1.25), 'gradient:'.$this->color('rtc').'-'.$this->color('lbc'));
			$helper->rotateImage(new \ImagickPixel(), 30);

			$x = round(-$this->width/1.55);
			$y = round(-$this->height/3);
			$this->canvas->compositeImage($helper, $helper->getImageCompose(), $x, $y);
			return $this;
		}


		private function draw_lightray()
		{
			$coords = array(
				array('x' => 0,                     'y' => round($this->width/8)),
				array('x' => 0,                     'y' => 0),
				array('x' => round($this->width/8), 'y' => 0),
				array('x' => $this->width,          'y' => round($this->height - 5*$this->height/8)),
				array('x' => $this->width,          'y' => $this->height),
				array('x' => round($this->width - 3*$this->width/8), 'y' => $this->height),
			);

			$mask = $this->create_layer();

			$draw = new \ImagickDraw();
			$draw->setFillColor($this->color('#fff'));
			$draw->polygon($coords);

			$mask->drawImage($draw);

			$glow = new \Imagick();
			$glow->newPseudoImage($this->width, $this->height, 'gradient:rgba(255,255,255,.5)-rgba(255,255,255,.1)');
			$glow->setImageVirtualPixelMethod(\Imagick::VIRTUALPIXELMETHOD_TRANSPARENT);
			$glow->setImageMatte(true);
			$glow->compositeImage($mask, \Imagick::COMPOSITE_DSTIN, 0, 0, \Imagick::CHANNEL_ALPHA);

			$this->canvas->compositeImage($glow, $glow->getImageCompose(), 0, 0);
			return $this;
		}


		private function draw_border()
		{
			$draw = new \ImagickDraw();
			$draw->setFillColor('transparent');
			$draw->setStrokeColor($this->color('black'));
			$draw->setStrokeWidth(self::SIZE_BORDER);
			$draw->rectangle(
				round(self::SIZE_BORDER/2),
				round(self::SIZE_BORDER/2),
				round($this->width - self::SIZE_BORDER/2),
				round($this->height - self::SIZE_BORDER/2)
			);

			$this->canvas->drawImage($draw);
			return $this;
		}


		private function draw_header()
		{
			$css = self::$texts['header'];
			$line = 0;
			$metrics = array();
			$rect_width = 0;

			$helper = $this->create_layer();

			foreach ($css['content'] as $text) {
				$m = $this->text($css, $text, $line++, $helper);
				$metrics[] = $m;

				if ($m['textWidth'] > $rect_width) {
					$rect_width = $m['textWidth'];
				}

			}
			$first = $metrics[0];
			$last  = $metrics[count($metrics)-1];

			$draw = new \ImagickDraw();
			$draw->setFillColor('transparent');
			$draw->setStrokeColor($this->color($css['color']));
			$draw->setStrokeWidth(12);
			$draw->rotate($css['angle']);
			$draw->rectangle(
				$first['x'] - 30,
				$first['y'] - $first['textHeight'] - 75,
				$last['x'] + $rect_width + 90,
				$last['y'] + $last['textHeight']
			);

			$helper->drawImage($draw);
			$helper->trimImage(.3);

			$this->composite($helper, self::$elements['header']['x'], self::$elements['header']['y']);
			return $this;
		}


		private function composite(\Imagick $helper, $x, $y, $use_shadow = true)
		{
			if ($use_shadow) {
				$shadow = self::get_shadow($helper);
				$this->canvas->compositeImage($shadow, $shadow->getImageCompose(), $x - self::SHADOW_SIZE, $y - self::SHADOW_SIZE);
			}

			$this->canvas->compositeImage($helper, $helper->getImageCompose(), $x, $y);
			return $this;
		}


		private function text($css, $text, $line = 0, \Imagick $helper = null)
		{
			if (is_null($helper)) {
				$helper = $this->canvas;
			}

			$draw = new \ImagickDraw();
			$draw->setFillColor($this->color($css['color']));
			$draw->setFont($this->font($css['font-family'], $css['font-weight']));
			$draw->setFontSize($css['font-size']);
			$draw->setStrokeAntialias(true);
			$draw->setTextAntialias(true);

			$metrics = $helper->queryFontMetrics($draw, $text);

			if (isset($css['text-align'])) {
				if ($css['text-align'] == self::TEXT_ALIGN_CENTER) {
					$css['x'] = ($this->width - $metrics['textWidth'])/2;
				}

				if ($css['text-align'] == self::TEXT_ALIGN_RIGHT) {
					$css['x'] = $css['x'] - $metrics['textWidth'];
				}
			}

			$helper->annotateImage($draw, $css['x'], $css['y'] + ($line * $css['line-height']), $css['angle'], $text);

			$metrics['x'] = $css['x'];
			$metrics['y'] = $css['y'];
			return $metrics;
		}


		private function draw_team_names()
		{
			$helper = $this->create_layer();
			$helper->setFormat('png');

			// Add versus sign to the center
			$css = self::$texts['versus'];
			$vs = $this->text($css, self::TEXT_VS, 0, $helper);

			$home = $this->event->team_home;
			$away = $this->event->team_away;

			// Add home team label left of versus sign
			$css_home = $css;
			$css_home['x'] = $vs['x'];
			$css_home['text-align'] = self::TEXT_ALIGN_RIGHT;
			$metrics_home = $this->text($css_home, $home->name, 0, $helper);

			// Add away team label right of versus sign
			$css_away = $css;
			$css_away['x'] = $vs['x'] + $vs['textWidth'];
			$css_away['text-align'] = self::TEXT_ALIGN_LEFT;
			$metrics_away = $this->text($css_away, $away->name, 0, $helper);


			// Add home team city under its label
			if ($home->city) {
				$css = self::$texts['cities'];
				$text = $home->city;
				$css['text-align'] = self::TEXT_ALIGN_RIGHT;
				$css['x'] = $metrics_home['x'] + $metrics_home['textWidth'];
				$css['y'] = $metrics_home['y'] + $css['font-size'] + 15;
				$this->text($css, $text, 0, $helper);
			}

			// Add away team city under its label
			if ($away->city) {
				$text = $away->city;
				$css['text-align'] = self::TEXT_ALIGN_LEFT;
				$css['x'] = $metrics_away['x'];
				$css['y'] = $metrics_away['y'] + $css['font-size'] + 15;
				$this->text($css, $text, 0, $helper);
			}

			// Add home team logo above its label
			if ($home->logo->is_image()) {
				$logo = new \Imagick($home->logo->get_path(true));
				$logo->trimImage(0.3);
				$logo->adaptiveResizeImage(null, self::LOGO_HEIGHT);

				$x = $metrics_home['x'] + $metrics_home['textWidth'] - $logo->getImageWidth();
				$y = $metrics_home['y'] - $metrics_home['textHeight'] - $logo->getImageHeight();

				$helper->compositeImage($logo, $logo->getImageCompose(), $x, $y);
			}

			// Add away team logo above its label
			if ($away->logo->is_image()) {
				$logo = new \Imagick($away->logo->get_path(true));
				$logo->trimImage(0.3);
				$logo->adaptiveResizeImage(null, self::LOGO_HEIGHT);

				$x = $metrics_away['x'];
				$y = $metrics_away['y'] - $metrics_away['textHeight'] - $logo->getImageHeight();

				$helper->compositeImage($logo, $logo->getImageCompose(), $x, $y);
			}

			$helper->trimImage(0.3);

			$x = ($this->width - $helper->getImageWidth())/2;
			$y = self::$texts['versus']['y'];

			$this->composite($helper, $x, $y);
			return $this;
		}


		private function draw_location()
		{
			$css = self::$texts['location'];
			$helper = $this->create_layer();
			$this->text($css, $this->ren->format_date($this->event->start, 'human'), 0, $helper);

			if ($this->event->location) {
				$location = $this->event->location;

				$this->text($css, $location->name, 1, $helper);
				$this->text($css, $location->addr, 2, $helper);

			}

			$helper->trimImage(0.3);
			$this->composite($helper, $css['x'] - $helper->getImageWidth(), $css['y']);

			return $this;
		}


		private function draw_footer()
		{
			$helper = $this->create_layer();
			$css = self::$texts['footer'];

			$this->text($css, 'Vygenerováno pomocí portálu Improliga.cz', 0, $helper);
			$helper->trimImage(0.3);

			$this->composite($helper, self::SIZE_BORDER*1.8, $this->height - 2.5*self::SIZE_BORDER);

			$logo = new \Imagick(ROOT.'/share/logo.png');
			$logo->setFormat('png');
			$logo->adaptiveResizeImage(self::SIZE_FOOTER_ITEMS, self::SIZE_FOOTER_ITEMS);
			$this->composite($logo, 800, 1800);
			return $this;
		}


		private function create_layer()
		{
			$layer = new \Imagick();
			$layer->newImage($this->width, $this->height, 'transparent');
			return $layer;
		}


		public static function get_shadow(\Imagick $img)
		{
			$template = clone $img;
			$template->trimImage(.3);
			$template->modulateImage(0, 0, 0);

			$shadow = new \Imagick();
			$shadow->newImage(
				$template->getImageWidth() + 2*self::SHADOW_SIZE,
				$template->getImageHeight() + 2*self::SHADOW_SIZE,
				'transparent'
			);
			$shadow->compositeImage($template, $template->getImageCompose(), self::SHADOW_SIZE, self::SHADOW_SIZE);
			$shadow->blurImage(self::SHADOW_SIZE, self::SHADOW_FUZZ);
			return $shadow;
		}


		private function font($name, $weight, $prop = 'path')
		{
			$val = self::$fonts[$name][$weight][$prop];
			return is_string($val) ? ROOT.$val:$val;
		}


		private function save()
		{
			\System\Directory::check(ROOT.self::DIR_TMP);

			$path = ROOT.self::DIR_TMP.'/'.$this->event->id.'.jpg';
			$this->canvas->setFormat('jpg');
			$this->canvas->writeImage($path);

			return \System\Image::from_path($path);
		}


		private function get_file()
		{
			if (!$this->output) {
				$this->output = ROOT.'/var/tmp/poster.png';
			}

			return $this->output;
		}

	}
}
