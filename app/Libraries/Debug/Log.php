<?php

namespace App\Libraries\Debug;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Console\Output\ConsoleOutput;

class Log
{

    // Nome do log no arquivo de texto
    private $logger;
    // saida do console
    private $consoleOutput;
    // Arquivo de log
    private $filename;
    // Arquivo que esta gerando log
    private $file;

    private $debug = false;


    /**
     * Cria um objeto de log
     * @param [type] $name
     * @param [type] $filename
     * @param boolean $debug
     */
    public function __construct($name, $file, $filename, $debug = false)
    {
        // Seta o modo Debug
        $this->debug = $debug;
        // Obtem o separador de acordo com S.O
        // Diretorio padrão de logs storage/logs
        $storage = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], storage_path() . DIRECTORY_SEPARATOR . "logs" . DIRECTORY_SEPARATOR . "$filename");
        // Seta o nome do arquivo
        $this->filename = $storage;
        // Seta o nome do arquivo que esta gerando log
        $this->file = $file;
        // Instancia objeto Logger
        $this->logger = new Logger($name);
        // Cria o log
        $this->logger->pushHandler(new StreamHandler($this->filename, Logger::DEBUG));
        // Instancia o objeto que irá exibir as mensagens no console
        $this->consoleOutput = new ConsoleOutput();
    }

    private function isOutPutConsoleMessage($type, $string)
    {
        if ($this->debug) {
            $path = explode(DIRECTORY_SEPARATOR, $this->file);
            $file = array_pop($path);
            $this->consoleOutput->writeln("$file - <$type>$string</$type>");
        }
    }

    private function log($type, $message)
    {
        $log = $message;

        switch ($type) {
            case 'info':
                $this->logger->info($log);
                break;
            case 'error':
                $this->logger->error($log);
                break;
            default:
                $type = 'comment';
                $this->logger->info($log);
                break;
        }
        $this->isOutPutConsoleMessage($type, $message);
        return $message;
    }

    public function info($message)
    {
        return $this->log('info', $message);
    }

    public function error($message)
    {
        return $this->log('error', $message);
    }

    public function alert($message)
    {
        return $this->log('alert', $message);
    }

    public function critical($message)
    {
        return $this->log('critical', $message);
    }

    public function warning($message)
    {
        return $this->log('warning', $message);
    }

    public function notice($message)
    {
        return $this->log('notice', $message);
    }

    public function debug($message)
    {
        return $this->log('debug', $message);
    }
}
