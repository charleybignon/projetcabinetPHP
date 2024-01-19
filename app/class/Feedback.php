<?php
namespace App\Class;

class Feedback {

    public static function setError(string $message) {
        $_SESSION["feedback"] = "<div class='row alert alert-danger divFeedback'>" . $message . "</div>";
    }

    public static function setSuccess(string $message) {
        $_SESSION["feedback"] = "<div class='row alert alert-success divFeedback'>" . $message . "</div>";
    }

    public static function removeMessage() {
        unset($_SESSION["feedback"]);
    }

    public static function getMessage() {
        $tmp = isset($_SESSION["feedback"]) ? $_SESSION["feedback"] : "";
        unset($_SESSION["feedback"]);
        return $tmp;
    }

}