<?php

namespace App\Services;

use Exception;

class FreeSwitchESLService
{
    protected $socket;
    protected $host;
    protected $port;
    protected $password;
    protected $connected = false;

    public function __construct()
    {
        $this->host = config('freeswitch.esl_host', '127.0.0.1');
        $this->port = config('freeswitch.esl_port', 8021);
        $this->password = config('freeswitch.esl_password', 'ClueCon');
    }

    public function connect(): bool
    {
        try {
            $this->socket = fsockopen($this->host, $this->port, $errno, $errstr, 10);
            
            if (!$this->socket) {
                throw new Exception("Failed to connect: $errstr ($errno)");
            }

            // Read auth request
            $this->readResponse();
            
            // Send auth
            $this->sendCommand("auth {$this->password}");
            $response = $this->readResponse();
            
            if (strpos($response, '+OK') !== false) {
                $this->connected = true;
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            logger()->error('FreeSWITCH ESL Connection Error: ' . $e->getMessage());
            return false;
        }
    }

    public function disconnect(): void
    {
        if ($this->socket) {
            fclose($this->socket);
            $this->connected = false;
        }
    }

    public function sendCommand(string $command): string
    {
        if (!$this->connected) {
            $this->connect();
        }

        fwrite($this->socket, "$command\n\n");
        return $this->readResponse();
    }

    public function api(string $command): string
    {
        return $this->sendCommand("api $command");
    }

    public function bgapi(string $command): string
    {
        return $this->sendCommand("bgapi $command");
    }

    protected function readResponse(): string
    {
        $response = '';
        $contentLength = 0;
        
        while ($line = fgets($this->socket)) {
            $response .= $line;
            
            if (preg_match('/Content-Length: (\d+)/', $line, $matches)) {
                $contentLength = (int)$matches[1];
            }
            
            if (trim($line) === '') {
                if ($contentLength > 0) {
                    $response .= fread($this->socket, $contentLength);
                }
                break;
            }
        }
        
        return $response;
    }

    public function originate(string $extension, string $destination): array
    {
        $command = "originate {$extension} {$destination}";
        $response = $this->api($command);
        
        return [
            'success' => strpos($response, '+OK') !== false,
            'response' => $response
        ];
    }

    public function hangup(string $uuid): array
    {
        $response = $this->api("uuid_kill $uuid");
        
        return [
            'success' => strpos($response, '+OK') !== false,
            'response' => $response
        ];
    }

    public function getChannels(): array
    {
        $response = $this->api('show channels as json');
        $data = json_decode($response, true);
        
        return $data['rows'] ?? [];
    }

    public function getRegistrations(): array
    {
        $response = $this->api('show registrations as json');
        $data = json_decode($response, true);
        
        return $data['rows'] ?? [];
    }

    public function reloadXml(): bool
    {
        $response = $this->api('reloadxml');
        return strpos($response, '+OK') !== false;
    }

    public function status(): array
    {
        $response = $this->api('status');
        
        return [
            'raw' => $response,
            'connected' => $this->connected
        ];
    }

    public function __destruct()
    {
        $this->disconnect();
    }
}
