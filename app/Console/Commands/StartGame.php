<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StartGame extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is for start a game';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /** Take input for Team A */
        $answer = $this->ask('Enter A Teams players(Comma saperated 5 numbers):');

        /** Apply filter and remove empty and negative number */
        $answer = array_filter(explode(",",$answer), function($value) { return !is_null($value) && $value !== '' && $value >0; });
        
        if(count($answer) == 5){
            $list1 = $answer;
        }else{
            /** If does not match the condition then error throw and exit it */
            $this->error("Team A : Should Enter 5 numeric strength that does not accept empty and negative number");
            exit;
        }

        /** Take input for Team B */
        $answer2 = $this->ask('Enter B Teams players(Comma saperated 5 numbers):');

        /** Apply filter and remove empty and negative number */
        $answer2 = array_filter(explode(",",$answer2), function($value) { return !is_null($value) && $value !== '' && $value >0; });
        if(count($answer2) == 5){
            $list2 = $answer2;
        }else{
            /** If does not match the condition then error throw and exit it */
            $this->error("Team B : Should Enter 5 numeric strength that does not accept empty and negative number");
            exit;
        }

        /** Calculate Team A and Team B date for finding the result */
            sort($list1);
            sort($list2);
            $list3=array();
            $arrlength = count($list2);
            for($x = 0; $x < $arrlength; $x++) {
                $search = $list2[$x];
                $key = $this->array_find($list1, function($value,$search) {
                    return $value > $search;
                },$search);
                /** check key done not given bool false value */
                if($key!==false){
                    unset($list1[$key]);
                }
                
                $list1 = array_values($list1);
            
            }
        /** Check for if Team A Won the game or Lose the game */
        if(count($list1)>0){
            $this->comment("A Lose");
        }else{
            $this->comment("A Win");
        }

    }

    /**
     * That function check the array value and find the if value is greater then search value
     * @param $a array()
     * @param callback function()
     * @param $search int
     * @return mixed
     */
    private function array_find(array $a, callable $fn, $search)
    {
        foreach ($a as $key => $value) {
            if ($fn($value, $search)) {
                return $key;
            }
        }
        return false;
    }
}
