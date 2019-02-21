<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function votes()
    {
        return $this->belongsToMany('App\CommunityLink', 'community_links_votes')->withTimestamps();
    }

    public function toggleVoteFor(CommunityLink $link)
    {
        CommunityLinkVote::firstOrNew([
            'user_id' => auth()->id(),
            'community_link_id' => $link->id,
        ])->toggle();
    }

    public function isTrusted()
    {
        return $this->trusted;
    }

    public function voteFor(CommunityLink $link)
    {
        return $this->votes()->sync([$link->id], false);
    }

    public function unvoteFor(CommunityLink $link)
    {
        return $this->votes()->detach($link);
    }

    public function votedFor(CommunityLink $link)
    {
        return $link->votes->contains('user_id', $this->id);
    }
}
