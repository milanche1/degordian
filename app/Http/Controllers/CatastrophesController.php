<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatastrophesController extends Controller
{
    public $randomizedEvents = ['eartqhuake', 'drunk', 'good strategy', 'generals'];

    public function generateRandomEvent($army, $whichArmy) : array
    {
        $eventLog = 'defaault';

        // Random if random event should be triggered at all
        if(rand(0,1) == 1) {
            // Makes a random Event
            switch ($this->randomizedEvents[rand(0, count($this->randomizedEvents) - 1)]) {
                case 'eartqhuake':
                    $eventLog = $whichArmy . ' army encountered earthquake! Many lives are lost due to natural catastrophe. Army health -50 ';
                    $army["army_health"] -= 50;
                    break;
                case 'drunk':
                    $eventLog = $whichArmy . ' army had a such fun last night. They event got an after party. Some of those overslept the battle. Army health -100, army strength -10';
                    $army["army_health"] -= 100;
                    $army["army_strength"] -= 10;
                    break;
                case 'good strategy':
                    $eventLog = $whichArmy . ' army has good strategy. They got everything right. Army health +50, army strength +20';
                    $army["army_health"] += 50;
                    $army["army_strength"] += 20;
                    break;
                case 'generals':
                    $eventLog = $whichArmy . ' army has some of the best generals. They are equied and ready to battle. Army health +70, army strength +30';
                    $army["army_health"] += 70;
                    $army["army_strength"] += 30;
                    break;
                default:
                    return $army;
                    break;
            }
            return [$army, $eventLog];
        }

        $eventLog =  $whichArmy . ' army has a fortune of rolling a dice and avoiding any random event!';

        return [$army, $eventLog];
    }
}
