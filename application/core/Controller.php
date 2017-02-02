<?php

/**
 * Base for every controller
 * Load functions for every page
 */
class Controller
{
    public $feedback = null;

    /**
     * If feedback exist -> set feedback to global var
     */
    function __construct()
    {
        if (isset($_GET['feedback'])) {
            $this->feedback = self::getFeedbackErrors($_GET['feedback']);
        }
    }

    /**
     * Load header, footer and view file
     */
    public function loadView($fileName, $data = null)
    {
        // Make data available
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require APPLICATION . 'view/templates/header.php';
        require APPLICATION . 'view/' . $fileName . '.php';
        require APPLICATION . 'view/templates/footer.php';
    }

    /**
     * Get feedback text based on feedback key word
     */
    public function getFeedbackErrors($feedback)
    {
        switch ($feedback) {
            case 'success':
                $feedback = 'Het is gelukt!';
                break;
            case 'notfound':
                $feedback = 'Niet gevonden!';
                break;
            case 'error':
                $feedback = 'Het is niet gelukt!';
                break;
            case 'nodata':
                $feedback = 'Zorg dat er bands/artiesten and podia aanwezig zijn!';
                break;
            case 'adderror':
                $feedback = 'Deze tijden zijn al in gebruik of onjuist!';
                break;
        }

        return $feedback;
    }
}
