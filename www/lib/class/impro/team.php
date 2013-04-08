<?

namespace Impro
{
	class Team extends \System\Model\Database
	{
		protected static $attrs = array(
			"name"       => array("varchar"),
			"name_full"  => array("varchar"),
			"city"       => array("varchar", "default" => ''),
			"about"      => array("text", "default" => ''),
			"logo"       => array('image', "default" => "/share/pixmaps/logo_original.png"),
			"photo"      => array('image', "default" => "/share/pixmaps/impro/team.png"),
			"site"       => array("varchar", "default" => ''),
			"played"     => array("int", "is_unsigned" => true, "default" => 0),
			"visible"    => array("bool"),
		);

		protected static $belongs_to = array(
			"author" => array("model" => "\System\User"),
			"hq"     => array("model" => "\System\Location"),
		);

		protected static $has_many = array(
			"members"   => array("model" => "\Impro\Team\Member"),
			"galleries" => array("model" => '\Impro\Gallery', "is_bilinear" => true),
			"comments"  => array("model" => '\Impro\Team\Comment'),
		);


		public function count_members()
		{
			return $this->members->count();
		}


		public function to_html_link($link, $short_name = true)
		{
			if ($short_name && mb_strlen($this->name_full) > 32) {
				$long_name = substr($this->name_full, 0, 32) . '...';
			} else {
				$long_name = $this->name_full;
			}

			return div('name', array(
				link_for($this->name, soprintf($link, $this), array("class" => 'short')),
				span('sep', ' - '),
				link_for($long_name, soprintf($link, $this), array("class" => 'full')),
			));
		}


		public function label($link_team)
		{
			return link_for(
				\Stag::span(array(
					"class" => "icon",
					"style" => "background:url(".$this->logo->thumb_trans(16, 16).'); width:16px; height:16px;',
					"close" => true,
				))
					.span('team_name_short', $this->name),
				soprintf($link_team, $this)
			);

		}
	}
}
