<?php

class TFrameActiveHelper {

    private $frameDefault;
    private $frameActivo;

    public function __construct($frameDefault, $session) {
        $this->frameDefault = $frameDefault;
        $this->getFrameSession($session);
    }

    private function getFrameSession($session) {
        if (isset($_SESSION[$session])) {
            $this->frameActivo = $_SESSION[$session];
            unset($_SESSION[$session]);
        } else {
            $this->frameActivo = $this->frameDefault;
        }
    }

    public function active($frame) {
        $active = '';
        if ($this->frameActivo === $frame) {
            $active = 'class="active"';
        }
        return $active;
    }

    public function frameActive($frame) {
        if ($this->frameActivo === $frame) {
            $active = 'class="frame active"';
        } else {
            $active = 'class="frame"';
        }
        return $active;
    }

}

?>