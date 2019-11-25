<?php
class Server
{
    public $ip             = "0.0.0.0";
    public $port           = 0;

    public $name           = "Unknown";
    public $version        = "Unknown";
    public $passworded     = false;
    public $players        = 0;
    public $max_players    = 0;
    public $map            = "Unknown";

    public $success        = false;

    public function __construct($ip, $port)
    {
        //Set IP and port

        $this->ip = $ip;
        $this->port = $port;

        //Load
        $this->Refresh();
    }

    public function Refresh()
    {
        $this->success = false;

        //Create stream

        $ip_array = explode(".", $this->ip);
        array_map("intval", $ip_array);

        $client = stream_socket_client("udp://{$this->ip}:{$this->port}");

        stream_set_timeout($client, 1);

        //Send request
        if ($client === false) return;

        $message    = "";

        $message   .= "VCMP";                        //Magic

        $message   .= chr($ip_array[0]);             //IP byte 0
        $message   .= chr($ip_array[1]);             //IP byte 1
        $message   .= chr($ip_array[2]);             //IP byte 2
        $message   .= chr($ip_array[3]);             //IP byte 3
        
        $message   .= chr($this->port & 0xFF);       //Port byte 0
        $message   .= chr($this->port >> 8 & 0xFF);  //Port byte 1
        
        $message   .= "i";                           //Opcode 'information'

        fwrite($client, $message);

        //Receive information

        //Header

        $header = fread($client, 11);
        if (strlen($header) < 11) return;

        $magic            = substr($header, 0, 4);           //Magic

        $server_ip      = "";                                //IP
        $server_ip     .= ord(substr($header, 4, 1));        //IP byte 0
        $server_ip     .= ".";                               //IP byte seperator
        $server_ip     .= ord(substr($header, 5, 1));        //IP byte 1
        $server_ip     .= ".";                               //IP byte seperator
        $server_ip     .= ord(substr($header, 6, 1));        //IP byte 2
        $server_ip     .= ".";                               //IP byte seperator
        $server_ip     .= ord(substr($header, 7, 1));        //IP byte 3

        $server_port    = 0;
        $server_port    += ord(substr($header, 8, 1));       //Port byte 0
        $server_port    += ord(substr($header, 9, 1)) << 8;  //Port byte 1
        
        $opcode         = substr($header, 10, 1);

        //Authencity checks

        if ($magic != "MP04") return;
        if ($server_ip != $this->ip) return;
        if ($server_port != $this->port) return;
        if ($opcode != "i") return;

        //Version

        $_version         = fread($client, 12);
        if (strlen($_version) < 12) return;

        $version = str_replace("\0", "", $_version);

        //Password

        $_passworded        = fread($client, 1);
        if (strlen($_passworded) < 1) return;
        
        $passworded = ord($_passworded) == 1;

        //Players

        $_players     = fread($client, 2);
        if (strlen($_players) < 2) return;

        $players    = 0;
        $players   += ord(substr($_players, 0, 1));
        $players   += ord(substr($_players, 1, 1)) << 8;

        //Max players

        $_max_players     = fread($client, 2);
        if (strlen($_max_players) < 2) return;

        $max_players    = 0;
        $max_players   += ord(substr($_max_players, 0, 1));
        $max_players   += ord(substr($_max_players, 1, 1)) << 8;
        
        //Server name

        $_name_len        = fread($client, 4);
        if (strlen($_name_len) < 4) return;

        $name_len    = 0;
        $name_len   += ord(substr($_name_len, 0, 1));
        $name_len   += ord(substr($_name_len, 1, 1)) << 8;
        $name_len   += ord(substr($_name_len, 2, 1)) << 16;
        $name_len   += ord(substr($_name_len, 3, 1)) << 24;
        
        $name             = fread($client, $name_len);
        if (strlen($name) < $name_len) return;

        //Gamemode

        $_gamemode_len    = fread($client, 4);
        if (strlen($_gamemode_len) < 4) return;

        $gamemode_len    = 0;
        $gamemode_len   += ord(substr($_gamemode_len, 0, 1));
        $gamemode_len   += ord(substr($_gamemode_len, 1, 1)) << 8;
        $gamemode_len   += ord(substr($_gamemode_len, 2, 1)) << 16;
        $gamemode_len   += ord(substr($_gamemode_len, 3, 1)) << 24;

        $gamemode         = fread($client, $gamemode_len);
        if (strlen($gamemode) < $gamemode_len) return;

        //Map namespace

        $_map_len         = fread($client, 4);
        if (strlen($_map_len) < 4) return;

        $map_len          = 0;
        $map_len   += ord(substr($_map_len, 0, 1));
        $map_len   += ord(substr($_map_len, 1, 1)) << 8;
        $map_len   += ord(substr($_map_len, 2, 1)) << 16;
        $map_len   += ord(substr($_map_len, 3, 1)) << 24;

        $map              = fread($client, $map_len);
        if (strlen($map) < $map_len) return;

        //We know everything now

        fclose($client);

        //Load it

        $this->name          = $name;
        $this->version       = $version;
        $this->passworded    = $passworded;
        $this->players       = $players;
        $this->max_players   = $max_players;
        $this->map           = $map;
        $this->success       = true;
    }
}

$server = new Server("62.234.76.209", 8192);
echo $server->name;
echo "#";
echo $server->version;
echo "#";
echo $server->passworded;
echo "#";
echo $server->players;
echo "#";
echo $server->max_players;
