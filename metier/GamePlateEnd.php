<?php


class GamePlateEnd {

    public function __construct () {

    }

    public function to_html() : string {
        $dao = new DAOParties();
        try {
            $scores = $dao->get_best_games(3);
            $str =
                "<div class='scoresTab'>
                    <table class='table table-hover'>
                        <thead class='thead-light'>
                             <tr>
                                <th scope='col'>#</th>
                                <th scope='col'>Pseudo</th>
                                <th scope='col'>Score</th>                              
                                <th scope='col'>Gagné ?</th>
                             </tr>
                        </thead>
                        <tbody>";
            for($i=1; $i<sizeof($scores)+1; $i++) {
                $str .= "   <tr>
                                <th scope='row'>".$i."</th>
                                <td>".$scores[$i-1]['pseudo']."</td>
                                <td>".$scores[$i-1]['score']."</td>
                                <td>".($scores[$i-1]['win']==1?"Oui":"Non")."</td>   
                            </tr>";
            }
            $str .= "</tbody></table></div>";
            return $str;
        } catch (SQLException $e) {

        }
    }
}