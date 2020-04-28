<?php

class App extends Model {

    const dir = "./app/";
    const filename = "datasikkerhetApp.apk";

    private $downloaded = false;

    public function __construct(MySQLi $mysqli, Monolog\Logger $logger, bool $downloaded = false) {
        parent::__construct($mysqli, $logger);
        $this->downloaded = $downloaded;
    }

    public function download(): App {

        $file = App::dir.App::filename;

        if (file_exists($file)) {
            header("Content-Description: File Transfer");
            header("Content-Type: application/vnd.android.package-archive");
            header("Content-Disposition: attachment; filename=".App::filename);
            header("Content-Transfer-Encoding: binary");
            header("Expires: 0");
            header("Cache-Control: must-revalidate; post-check: 0, pre-check=0");
            header("Pragma: public");
            header("Content-Length: ".filesize($file));
            ob_clean();
            flush();

            readfile($file);

            $this->logger->info('Bruker lastet ned appen.', ['brukernavn' => $_SESSION['user']]);

            return new App($this->mysqli, $this->logger, true);
        }

        $this->logger->info('Bruker prøvde å laste ned appen, men det oppstod en feil.', ['brukernavn' => $_SESSION['user']]);

        return $this;
    }

    public function isDownloaded() {
        return $this->downloaded;
    }

}

?>