<?php

/**
 * Class responsavel pelos feedback predefinidos no sistema
 * @author igorsantos
 */
class TFeedbackHelper {

    /**
     * Verifica se existe uma session feedback
     * @return boolean
     */
    public static function isFeedback() {
        if (isset($_SESSION['feedback'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function getFeedback() {
        return $_SESSION['feedback'];
    }

    public static function deleteFeedback() {
        unset($_SESSION['feedback']);
    }

    public static function notifySuccess($mensagem) {
        $_SESSION['feedback'][]['success'] = $mensagem;
    }

    public static function notifyWarning($mensagem) {
        $_SESSION['feedback'][]['warning'] = $mensagem;
    }

    public static function notifyError($mensagem) {
        $_SESSION['feedback'][]['error'] = $mensagem;
    }

    /**
     * Retorna o feedback
     * @return feedback
     */
    public static function displayFeedback() {

        $script = '';

        if (TFeedbackHelper::isFeedback()) {

            $time = 1000;
            $script .= '<script>';
            $script .= '$(document).ready(function() {';

            foreach (TFeedbackHelper::getFeedback() as $action) {

                if (isset($action['success'])) {
                    $script .= 'setTimeout(function(){';
                        $script .= '$.Notify({style: {background: "green", color: "white"}, content: "<b>'.$action['success'].'</b>", timeout: 10000});';
                    $script .= '}, ' . $time . ');';
                } elseif (isset($action['warning'])) {
                    $script .= 'setTimeout(function(){';
                        $script .= '$.Notify({style: {background: "#fa6800", color: "white"}, content: "<b>'.$action['warning'].'</b>", timeout: 10000});';
                    $script .= '}, ' . $time . ');';                    
                } elseif (isset($action['error'])) {
                    $script .= 'setTimeout(function(){';
                        $script .= '$.Notify({style: {background: "red", color: "white"}, content: "<b>'.$action['error'].'</b>", timeout: 10000});';
                    $script .= '}, ' . $time . ');';                    
                }

                $time += 1000;
            }
            $script .= '});';
            $script .= '</script>';
            TFeedbackHelper::deleteFeedback();
        }

        return $script;
    }

}

?>
