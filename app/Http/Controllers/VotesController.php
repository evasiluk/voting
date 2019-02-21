<?php

namespace App\Http\Controllers;

use App\CommunityLink;
use App\CommunityLinkVote;
use Illuminate\Http\Request;

class VotesController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }
    public function store(CommunityLink $link)
    {
        auth()->user()->toggleVoteFor($link);

//        if($user->votedFor($link)) {
//            auth()->user()->unvoteFor($link);
//        } else {
//            auth()->user()->voteFor($link);
//        }





        return back();
    }
}
