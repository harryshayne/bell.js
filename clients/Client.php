<?php
namespace Eleme;

class Client
{
    private $host;
    private $port;
    private $socket;

    public function __construct($host, $port = 8889)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function send($data)
    {
        $data = json_encode($data);
        $string = strlen($data)."\n".$data;
        return $this->write($string);
    }

    private function write($buffer)
    {
        $socket = $this->getSocket();

        while (($length = strlen($buffer)) > 0) {
            $written = socket_write($socket, $buffer, $length);

            if ($length === $written) {
                return true;
            }

            if ($written === false || $written === 0) {
                return false;
            }

            $buffer = substr($buffer, $written);
        }
    }

    private function getSocket()
    {
        if ($this->socket !== null) {
            return $this->socket;
        }
        $this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        socket_set_option($this->socket, SOL_SOCKET, SO_REUSEADDR, 1);
        socket_set_block($this->socket);
        socket_connect($this->socket, $this->host, $this->port);
        return $this->socket;
    }
}
