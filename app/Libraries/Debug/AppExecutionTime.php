<?php

namespace App\Libraries\Debug;

class AppExecutionTime
{
    /**
     * Inicio do Script
     *
     * @var Datetime
     */
    private $scriptStart;
    /**
     * Final do Script
     *
     * @var Datetime
     */
    private $scriptEnd;
    /**
     * Tempo de exeução
     *
     * @var Datetime
     */
    private $elapsedTime;

    public function start()
    {
        list($usec, $sec) = explode(' ', microtime());
        $this->scriptStart = (float) $sec + (float) $usec;
        return "Programa iniciou: " . date('H:i:s', $this->scriptStart);
    }

    public function end()
    {
        list($usec, $sec) = explode(' ', microtime());
        $this->scriptEnd = (float) $sec + (float) $usec;
        $this->elapsedTime = round($this->scriptEnd - $this->scriptStart, 5);

        $hours = (int) ($this->elapsedTime / 60 / 60);
        $minutes = (int) ($this->elapsedTime / 60) - $hours * 60;
        $seconds = (int) $this->elapsedTime - $hours * 60 * 60 - $minutes * 60;

        return "Programa finalizou: " . date('H:i:s', $this->scriptEnd) . " => Tempo: h:$hours n:$minutes s:$seconds";
    }
}
