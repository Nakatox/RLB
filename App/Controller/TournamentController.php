<?php



namespace App\Controller;

use Cocur\Slugify\Slugify;
use App\Model\TournamentModel;
use Framework\Controller;


class TournamentController extends Controller {

    public function showTournaments() {
        $tournamentModel = new TournamentModel();
        $tournaments = $tournamentModel->tournaments();
        $this->renderTemplate('tournament-list.html.twig', [
            'tournaments' => $tournaments
            
            ]);
            return;
    }

    public function showClassements() {
        $tournamentModel = new TournamentModel();
        $classements = $tournamentModel->classements();
        $this->renderTemplate('classement-list.html.twig', [
            'classements' => $classements
            
            ]);
            return;
    }
    

}






?>