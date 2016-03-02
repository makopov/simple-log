<?php
/** 
 * Created by Michael Akopov
 * makopov@gmail.com
 * http://michaelakopov.com
 *
 * SimpleLog - Simple Log
 * A simple log wrapper around 
 */

/**
 * A simple logging class wrapper around syslog,
 * loosely based off of the PSR3 standard
 */

namespace simplelog

class SimpleLog {
  const EMERGENCY = LOG_EMERG;
  const ALERT     = LOG_ALERT;
  const CRITICAL  = LOG_CRIT;
  const ERROR     = LOG_ERR;
  const WARNING   = LOG_WARNING;
  const NOTICE    = LOG_NOTICE;
  const INFO      = LOG_INFO;
  const DEBUG     = LOG_DEBUG;
  private static $oInstance = null;
  private $strApplicationName = 'php';

  /**
   * SimpleLog constructor.
   *
   * Opening a log connection with our logging details
   */
  private function __construct() {
    openlog($this->strApplicationName, LOG_ODELAY, LOG_USER);
  }

  /**
   * Calling closelog() is optional, this is for good measure
   */
  function __destruct() {
    closelog();
  }

  /**
   * Singelton implementation, returns the same instance of SimpleLog
   * @return SimpleLog
   */
  public static function getInstance() {
    if(static::$oInstance == null) {
      static::$oInstance = new SimpleLog();
    }

    return static::$oInstance;
  }

  public function setApplicationName($strApplicationName) {
    $this->strApplicationName = $strApplicationName;
  }

  public function emergency($strMessage, $aContext = array()) {
    $this->log(self::EMERGENCY, $strMessage, $aContext);
  }

  public function alert($strMessage, $aContext = array()) {
    $this->log(self::ALERT, $strMessage, $aContext);
  }

  public function critical($strMessage, $aContext = array()) {
    $this->log(self::CRITICAL, $strMessage, $aContext);
  }

  public function error($strMessage, $aContext = array()) {
    $this->log(self::ERROR, $strMessage, $aContext);
  }

  public function warning($strMessage, $aContext = array()) {
    $this->log(self::WARNING, $strMessage, $aContext);
  }

  public function notice($strMessage, $aContext = array()) {
    $this->log(self::NOTICE, $strMessage, $aContext);
  }

  public function info($strMessage, $aContext = array()) {
    $this->log(self::INFO, $strMessage, $aContext);
  }

  public function debug($strMessage, $aContext = array()) {
    $this->log(self::DEBUG, $strMessage, $aContext);
  }

  public function log($strLevel, $strMessage, $aContext = array()) {
    $oDebugTrace = debug_backtrace('DEBUG_BACKTRACE_IGNORE_ARGS');
    $strCalledFrom = '';

    if(isset($oDebugTrace[1])) {
      $oCaller = $oDebugTrace[1];

      if (isset($oCaller['file']) && isset($oCaller['line'])) {
        $strCalledFrom = $oCaller['file'] . ':' . $oCaller['line'];
      }

    }

    $strMessage .= '. Context: ' . $this->parseContext($aContext);

    syslog($strLevel, basename($strCalledFrom) . ' - ' . $strMessage);
  }

  /**
   * For now this function is converting context to JSON, not sure how best to
   * format this yet. But we dont want to loose the data.
   *
   * @param $aContext
   * @return string (JSON)
   */
  private function parseContext($aContext) {
    return json_encode($aContext);
  }
}
