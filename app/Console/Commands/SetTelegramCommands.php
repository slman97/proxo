<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class SetTelegramCommands extends Command
{
    protected $signature = 'telegram:set-commands';
    protected $description = 'Set Telegram Bot Commands';

    public function handle()
    {
        Telegram::setMyCommands([
            'commands' => [
                ['command' => 'start', 'description' => 'ابدأ استخدام البوت'],
                ['command' => 'help', 'description' => 'الحصول على مساعدة'],
            ],
        ]);

        $this->info('Telegram commands set successfully!');
    }

}
