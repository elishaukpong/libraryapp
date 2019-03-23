<?php

namespace App\Console\Commands;

use App\Models\BorrowBooks;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use  App\Mail\ReturnBorrowedBookNotification;

class CheckBorrowedBookTimeline extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'borrowedbooks:timeline';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for borrowed book timeline';

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
        $borrowedBooks = BorrowBooks::whereReturned(0)->get();
        foreach($borrowedBooks as $book){
            $now = \Carbon\Carbon::now();
            $timeline = $book->return_date->diffInDays($now);
            if($book->return_date->greaterThan($now) && $timeline ==  7){
               Mail::to($book->user->email)->send(new ReturnBorrowedBookNotification($book, $timeline));
            }
        }
    }
}
