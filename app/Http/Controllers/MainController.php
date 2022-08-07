<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ArmiesController;

class MainController extends Controller
{
    private $instanceOf;

    public function __construct()
    {
        $this->instanceOf = new ArmiesController();
    }

    public function main(): \Illuminate\View\View
    {
        return view('welcome');
    }

    public function getData(Request $req)
    {
        $firstArmy = $this->instanceOf->giveWeapons($req->input(["army_one"]));
        $secondArmy = $this->instanceOf->giveWeapons($req->input(["army_two"]));

        $resa = $this->instanceOf->toBattle($firstArmy, $secondArmy);

        return view('battle', ['resa' => $resa]);
    }
}
