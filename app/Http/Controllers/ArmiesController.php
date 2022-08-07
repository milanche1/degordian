<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArmiesController extends Controller
{
    private $instanceOf;

    public function __construct()
    {
        $this->instanceOf = new CatastrophesController();
    }

    // There are several options for weapons, which has strength listed down below
    public $weapon = ['cold weapon', 'pistols', 'guns', 'rpg'];
    public $armyStrength = 0;
    public $armyHealth = 80;

    public function giveWeapons($numOfSoldiers) : array
    {
        // Randomized event for giving army weapons and health
        // Armies which have more attach points will have less health
        switch ($this->weapon[rand(0, count($this->weapon) - 1)])
        {
            case 'cold weapon':
                $this->armyHealth *= 0.02;
                $this->armyStrength = 15;
                break;
            case 'pistols':
                $this->armyHealth *= 0.015;
                $this->armyStrength = 25;
                break;
            case 'guns':
                $this->armyHealth *= 0.01;
                $this->armyStrength = 45;
                break;
            case 'rpg':
                $this->armyHealth *= 0.008;
                $this->armyStrength = 85;
                break;
            default:
                return 0;
                break;
        }

        $this->armyHealth = $this->armyHealth * $numOfSoldiers;

        return array('army_strength' => $this->armyStrength, 'army_health' => $this->armyHealth);
    }

    public function toBattle($firstArmy, $secondArmy) : array
    {
        // array for logs of the battle instead of using db
        $battleLog = [];

        if(rand(0,1) == 1) {
            $firstArmyRes = $this->instanceOf->generateRandomEvent($firstArmy, 'First');
            $firstArmy = $firstArmyRes[0];
            array_push($battleLog, $firstArmyRes[1]);
        } else {
            $secondArmyRes = $this->instanceOf->generateRandomEvent($secondArmy, 'Second');
            $secondArmy = $secondArmyRes[0];
            array_push($battleLog, $secondArmyRes[1]);
        }

        // Rolling dice for first attack
        if(rand(0,1) == 1) {
            array_push($battleLog, 'First army is attacking first');
            $secondArmy["army_health"] -= $firstArmy["army_strength"];
            array_push($battleLog, 'First army attacked with: ' . $firstArmy["army_strength"] . ' attack points and left second army with ' . $secondArmy["army_health"] . ' health points');
        } else {
            array_push($battleLog, 'Second army is attacking first');
            $firstArmy["army_health"] -= $secondArmy["army_strength"];
            array_push($battleLog, 'Second army attacked with: ' . $secondArmy["army_strength"] . ' attack points and left first army with ' . $firstArmy["army_health"] . ' health points');
        }

        // Armies are attacking each other while they have health
        while($firstArmy["army_health"] > 0 && $secondArmy["army_health"] > 0) {
            $secondArmy["army_health"] -= $firstArmy["army_strength"];
            array_push($battleLog, 'First army attacked with: ' . $firstArmy["army_strength"] . ' attack points and left second army with ' . $secondArmy["army_health"] . ' health points');
            $firstArmy["army_health"] -= $secondArmy["army_strength"];
            array_push($battleLog, 'Second army attacked with: ' . $secondArmy["army_strength"] . ' attack points and left first army with ' . $firstArmy["army_health"] . ' health points');
        }

        array_push($battleLog, 'This round contained ' . count($battleLog) - 1 . ' cycles of attacks!');

        return $battleLog;
    }
}
