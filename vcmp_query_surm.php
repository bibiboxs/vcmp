<?php
class VCMPQuery {

	private $Socket = false;
	
	private $aData = array();
	
	private $aServer = array();

	public function __construct($Server, $Port = 5192)
	{
		$this->aServer[0] = $Server;
		$this->aServer[1] = $Port;
		$this->Socket = fsockopen('udp://'.$Server, $Port, $Errno, $Errstr, 2);
		$this->aData[0] = true;
		if(!$this->Socket)
		{
			$this->aData[0] = false;
			return;
		}
		
		socket_set_timeout($this->Socket, 2);
		
		$sPacket = 'VCMP';
		$sPacket .= chr(strtok($Server, '.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr($Port & 0xFF);
		$sPacket .= chr($Port >> 8 & 0xFF);
		
		fwrite($this->Socket, $sPacket.'p4150');
		
		if(fread($this->Socket, 10))
		{
			if(fread($this->Socket, 5) == 'p4150')
			{
				$this->aData[0] = true;
				return;
			}
		}
		
		$this->aData[0] = false;
	}
	
	public function getInfo()
	{
		// Request server info and player info
		$aData = array();
		
		@fwrite($this->Socket, $this->createPacket('i'));
		
		fread($this->Socket, 11);
	
		$aData['password'] = ord(fread($this->Socket, 1));
		
		$aData['players'] = ord(fread($this->Socket, 2));
		
		$aData['maxplayers'] = ord(fread($this->Socket, 2));
		
		$iStrlen = ord(fread($this->Socket, 4));
		if(!$iStrlen) return -1;
		
		$aData['hostname'] = (string) fread($this->Socket, $iStrlen);
		
		$iStrlen = ord(fread($this->Socket, 4));
		$aData['gamemode'] = (string) fread($this->Socket, $iStrlen);
		
		$iStrlen = ord(fread($this->Socket, 4));
		$aData['mapname'] = (string) fread($this->Socket, $iStrlen);
		
		return $aData;
	}
	public function getPlayers()
	{
		fwrite($this->Socket, $this->createPacket('c'));
		fread($this->Socket, 11);
		$plr_count = ord(fread($this->Socket, 2));
		if ($plr_count > 0)
		{
			$players = array();
			for ($i=0; $i<$plr_count; $i++)
			{
				$strlen = ord(fread($this->Socket, 1));
				$plrname = fread($this->Socket, $strlen);
				$score = $this->getLong(fread($this->Socket, 4));
				$players[] = array( $plrname, $score);
			}
			return $players;
		}
		return false;

	}
	
	public function __destruct()
	{
		@fclose($this->Socket);
	}
	
	private function createPacket($req)
	{
		$sPacket = 'VCMP';
		$sPacket .= chr(strtok($this->aServer[0], '.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr(strtok('.'));
		$sPacket .= chr($this->aServer[1] & 0xFF);
		$sPacket .= chr($this->aServer[1] >> 8 & 0xFF);
		$sPacket .= $req;
	
		return $sPacket;
	}
	
	public function isAlive()
	{
		return $this->aData[0];
	}

	private function getLong($dat)
	{
		$num=0;
		if ((ord(substr($dat,3,1)) & 128) > 0) {
			for ($i=0; $i<strlen($dat); $i++) {
				$num-=((255-ord(substr($dat,$i,1))) << 8*$i);
			}
			$num--;
		} else {
			for ($i=0; $i<strlen($dat); $i++) {
				$num+=(ord(substr($dat,$i,1)) << 8*$i);
			}
		}
		return $num;
	}
	
}
?>