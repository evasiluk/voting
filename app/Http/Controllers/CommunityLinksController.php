<?php

namespace App\Http\Controllers;

use App\Queries\CommunityLinksQuery;
use Illuminate\Http\Request;
use App\CommunityLink;
use App\Channel;
use App\Exceptions\CommunityLinkAlreadySubmited;
use App\Http\Requests\CommunityLinkRequest;


class CommunityLinksController extends Controller
{
    public function index(Channel $channel = null)
    {
        $links =(new CommunityLinksQuery)->get($channel, request()->exists('popular'));
        $channels = Channel::orderBy('title', 'asc')->get();

        return view('community.index', compact('links', 'channels', 'channel'));
    }

    public function store(CommunityLinkRequest $request)
    {
        try {
            CommunityLink::from(auth()->user())->contribute($request->all());

            if(auth()->user()->isTrusted()) {
                flash('Thanks for contribution');
            } else {
                flash('Thanks, this contribution will be approved shortly');
            }
        } catch(CommunityLinkAlreadySubmited $e) {
            flash()->overlay("We'll instead bump the timestamps and bring that link to the top. Thanks!", "That link has already been submited");
        }

        return back();
    }
}
