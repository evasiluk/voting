<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\CommunityLinkAlreadySubmited;


class CommunityLink extends Model
{
    protected $fillable = ['channel_id', 'title', 'link'];

    public static function from(User $user)
    {
        $link = new static;
        $link->user_id = $user->id;

        if($user->isTrusted()){
            $link->approved = 1;
        }

        return $link;
    }

    public function contribute($attributes) {
        if($existing = $this->hasAlreadyBeenSubmitted($attributes['link'])) {
            $existing->touch(); // touch() это встроенный метод, который обновляет timestamps

            throw new CommunityLinkAlreadySubmited;
        }

        return $this->fill($attributes)->save();
    }

    public function scopeForChannel($builder, $channel) {
        if($channel) {
            return $builder->where('channel_id', $channel->id);
        }

        return $builder;
    }

    public function creator()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo('App\Channel');
    }


    /**
     * A community link has many votes
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany(CommunityLinkVote::class, 'community_link_id');
    }

    protected function hasAlreadyBeenSubmitted($link)
    {
        return static::where('link', $link)->first();
    }
}
