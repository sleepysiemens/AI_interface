<?php

namespace App\Telegram;

use App\Models\User;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Handler extends WebhookHandler
{
    public function start()
    {
        $reg_check=User::query()->where('tg_id','=',$this->message->toArray()['chat']['id'])->exists();

        if($reg_check)
        {
            $user=User::query()->where('tg_id','=',$this->message->toArray()['chat']['id'])->first();
        }

        else
        {
            $password=Str::random(8);

            $user = new User;

            $user->email = 'TG: @'.$this->message->toArray()['chat']['title'];
            $user->name = $this->message->toArray()['from']['first_name'];
            $user->password = Hash::make($password);
            $user->locale = app()->getLocale();
            $user->timezone = config('settings.timezone');
            $user->api_token = Str::random(64);
            $user->tfa = config('settings.registration_tfa');
            $user->default_language = config('settings.openai_default_language');
            $user->tg_id = $this->message->toArray()['chat']['id'];
            $user->markEmailAsVerified();

            $user->save();
        }

        $hash=Hash::make($user->created_at.date("YmdHis").$user->tg_id);
        $hash=str_replace(['/'], '', $hash);
        Cache::put($hash, $user, now()->addMinutes(5));

        $this->reply(route('tg.auth',$hash));

    }
}
