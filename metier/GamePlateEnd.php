<?php


class GamePlateEnd {

    public function __construct () {

    }

    public function getScores() : string {
        $dao = new DAOParties();
        //$scores = $dao->get_best_games(3);
        $scores = array(array());
        $scores[0]['pseudo'] = "thowisk";
        $scores[0]['score'] = 2048;
        $scores[0]['win'] = true;
        $scores[1]['pseudo'] = "loicyeu";
        $scores[1]['score'] = 2;
        $scores[1]['win'] = false;
        $str =
            "<div class='scoresTab'>
                    <table class='table'>
                        <thread>
                             <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>pseudo</th>
                                <th scope='col'>score</th>                              
                                <th scope='col'>gagné ?</th>
                             </tr>
                        </thread>
                        <tbody>";
            for($i=1; $i<sizeof($scores)+1; $i++) {
                $str .= "   <tr>
                                <th scope='row'>".$i."</th>
                                <td>".$scores[$i-1]['pseudo']."</td>
                                <td>".$scores[$i-1]['score']."</td>
                                <td>".$scores[$i-1]['win']."</td>   
                            </tr>";
            }
            $str .= "</tbody></table></div>";
            return $str;
    }
}