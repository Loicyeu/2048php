<?php

class VueGame {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        ?>

        <div class="grid-container">
            <div class="grid-item">1</div>
            <div class="grid-item">2</div>
            <div class="grid-item">3</div>
            <div class="grid-item">4</div>
            <div class="grid-item">5</div>
            <div class="grid-item">6</div>
            <div class="grid-item">7</div>
            <div class="grid-item">8</div>
            <div class="grid-item">9</div>
            <div class="grid-item">10</div>
            <div class="grid-item">11</div>
            <div class="grid-item">12</div>
            <div class="grid-item">13</div>
            <div class="grid-item">14</div>
            <div class="grid-item">15</div>
            <div class="grid-item">16</div>
        </div>

        <div class="move-grid">
            <form action="index.php" method="GET" class="up">
                 <input name="up" type="submit" value="/\">
            </form>
            <form action="index.php" method="GET" class="left">
                <input name="POST" type="submit" value="<">
            </form>
            <form action="index.php" method="GET" class="right">
                <input name="right" type="submit" value=">">
            </form>
            <form action="index.php" method="GET" class="down">
                <input name="down" type="submit" value="V">
            </form>
        </div>


        <?php
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    public function display_test(string $s) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo $s;
        echo "<div class='move-grid'>
            <form action='index.php' method='GET' class='up'>
                <button type='submit' name='up'>
                    <img src='assets/arrow-up-solid.svg' alt='/\'/>
                </button>
            </form>
            <form action='index.php' method='GET' class='left'>
                <button type='submit' name='left'>
                    <img src='assets/arrow-left-solid.svg' alt='>'/>
                </button>
            </form>
            <form action='index.php' method='GET' class='right'>
                <button type='submit' name='right'>
                    <img src='assets/arrow-right-solid.svg' alt='V'/>
                </button>
            </form>
            <form action='index.php' method='GET' class='down'>
                <button type='submit' name='down'>
                    <img src='assets/arrow-down-solid.svg' alt='<'/>
                </button>
            </form>
        </div>";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    public function display_home() {
        //TODO:
        // - interface permettant de choisir si on veut commencer une nouvelle game
        // - ou charger celle en sauvegarde s'il y en a une
        $str = "<div class='grid-container blur'>";
        for ($i=0; $i<16; $i++)
            $str .= "<div class='tile'></div>";
        $str .= "</div>";

        include(PATH_HTMLCSS . "/htmlHead.php");
        echo $str;
        echo "
        <div class='begin'>
            <h1 style='text-align: center; margin-top: 5px'>Le jeu du 2048</h1>
            <form method='post' action='index.php' style='text-align: center'>
                <input type='submit' value='Nouvelle partie' name='new'>
            </form>
            <form method='post' action='index.php' style='text-align: center'>
                <input type='submit' value='Charger partie' name='save'>
            </form>
        </div>
        ";
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}