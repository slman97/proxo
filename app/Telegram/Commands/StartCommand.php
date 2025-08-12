<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;
use App\Models\TelegramUser;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'بدء استخدام البوت';

    public function handle()
    {
        $keyboard = [
            ['🌐 1. طلب بروكسي'],
            ['👤 2. حسابي', '🔍 3. فحص بروكسي'],
            ['❓ 4. مساعدة'],
        ];

        $userId = $this->getUpdate()->getMessage()->getFrom()->getId();

        $user = TelegramUser::where('telegram_id', $userId)->first();

        if (!$user) {
            TelegramUser::create([
                'telegram_id' => $userId,
                'credit' => 0.00,
            ]);

            $this->replyWithMessage([
                'text' => "🎉 أهلاً بك! تم إنشاء حسابك بنجاح.\nرصيدك الحالي: 0.00 USD",
                'reply_markup' => json_encode([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false,
                ]),
            ]);
        } else {
            $this->replyWithMessage([
                'text' => "👋 أهلاً بعودتك! رصيدك الحالي: {$user->credit} USD",
                'reply_markup' => json_encode([
                    'keyboard' => $keyboard,
                    'resize_keyboard' => true,
                    'one_time_keyboard' => false,
                ]),
            ]);
        }
    }
}
