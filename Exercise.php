<?php

abstract class Supervisor
{
    protected $slogan;
    //Print slogan to the screen
    abstract function saySloganOutLoud();
}

interface Boss
{
    //Check slogan
    function checkValidSlogan();
}

trait Active
{
    //Get class
    function defindYourSelf() {
        return get_class($this);
    }
}

class EnglandBoss extends Supervisor implements Boss
{
    use Active;
    
    /**
     * Set slogan
     * 
     * @param $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * Check slogan include at least 1 keyword
     * 
     * @param $slogan
     * @return bool
     */
    public function checkValidSlogan()
    {
        $keyword1 = 'after';
        $keyword2 = 'before';

        if ((strpos($this->slogan,$keyword1) !== false) || (strpos($this->slogan,$keyword2) !== false)) {
            return true;
        }
        return false;
    }

    //Print slogan to the screen
    public function saySloganOutLoud()
    {
        echo $this->slogan;
    }
}

class ItalyBoss extends Supervisor implements Boss
{
    use Active;
    
    /**
     * Set slogan
     * 
     * @param $slogan
     */
    public function setSlogan($slogan)
    {
        $this->slogan = $slogan;
    }

    /**
     * Check slogan include both keywords or not
     * 
     * @param $slogan
     * @return bool
     */
    public function checkValidSlogan()
    {
        $keyword1 = 'after';
        $keyword2 = 'before';

        if ((strpos($this->slogan,$keyword1) !== false) && (strpos($this->slogan,$keyword2) !== false)) {
            return true;
        }
        return false;
    }

    //Print slogan to the screen
    public function saySloganOutLoud()
    {
        echo $this->slogan;
    }
}

$englandBoss  = new EnglandBoss();
$italyBoss  = new ItalyBoss();

$englandBoss->setSlogan('Do NOT push anything to master branch before reviewed by supervisor(s)');

$italyBoss->setSlogan('Do NOT push anything to master branch before reviewed by supervisor(s). Only they can do it after check it all!');

$englandBoss->saySloganOutLoud();
echo "<br>";
$italyBoss->saySloganOutLoud();

echo "<br>";

echo 'I am ' . $englandBoss->defindYourSelf();
echo "<br>";
echo 'I am ' . $italyBoss->defindYourSelf();

echo "<br>";

var_dump($englandBoss->checkValidSlogan()); // true
echo "<br>";
var_dump($italyBoss->checkValidSlogan()); // true

?>
