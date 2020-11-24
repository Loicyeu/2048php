<?php

include_once PATH_VUE."/Vue.php";

class VueGame implements Vue {

    public function display() {
        include(PATH_HTMLCSS . "/htmlHead.php");
        //<body>
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
            <form action="index.php" method="post" class="left>
                <input name="left" type="submit" value="<">
            </form>
            <form action="index.php" method="GET" class="right">
                <input name="right" type="submit" value=">">
            </form>
            <form action="index.php" method="GET" class="down">
                <input name="down" type="submit" value="V">
            </form>
        </div>


        <?php
        //</body>
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

    public function display_test(string $s) {
        include(PATH_HTMLCSS . "/htmlHead.php");
        echo $s;
        include(PATH_HTMLCSS . "/htmlFoot.php");
    }

}