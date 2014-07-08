<?
/*
namespace Impro\User\Request
{
	class JoinTraining implements \Impro\User\Request\Callback
	{
		public static function yes(\Impro\User\Request $req)
		{
			return self::create($req, \Impro\Team\Training\Ack::RESPONSE_YES);
		}


		public static function no(\Impro\User\Request $req)
		{
			return self::create($req, \Impro\Team\Training\Ack::RESPONSE_NO);
		}


		public static function maybe(\Impro\User\Request $req)
		{
			return self::create($req, \Impro\Team\Training\Ack::RESPONSE_MAYBE);
		}


		private static function create(\Impro\User\Request $req, $response)
		{
			$ack = $req->training->acks->where(array(
				"id_user" => $req->user->id,
				"id_training" => $req->training->id,
			))->fetch_one();

			if ($ack) {
				$ack->update_attrs(array(
					"count"    => 1,
					"status"   => $response,
				))->save();

				return $ack instanceof \Impro\Team\Training\Ack;
			}
		}
	}
}
*/
