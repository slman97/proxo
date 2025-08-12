<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\TelegramUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{
    public function webhookHandler(Request $request)
    {
        $update = Telegram::getWebhookUpdate();
        Telegram::commandsHandler(true);
        if ($update->isType('message')) {
            $message = $update->getMessage();
            $text = $message->getText();
            $chatId = $message->getChat()->getId();

            $userId = $message->getFrom()->getId();

            $user = TelegramUser::where('telegram_id', $userId)->first();

            if (preg_match('/^(\d{6,})\/(\d+)$/', $text, $matches)) {
                $transactionNumber = $matches[1];
                $amount = $matches[2];

                $recharge = Payment::where('amount', $amount)->where('payment_id', $transactionNumber)->first();
                if ($recharge) {
                if (!$recharge->confirmed) {
                    $recharge->status = 'accepted';
                    $recharge->telegram_id = $userId;
                    $recharge->date_of_accept = Carbon::now()->format('Y-m-d');
                    $recharge->save();

                    $user = TelegramUser::where('telegram_id', $chatId)->first();
                    if ($user) {
                        $creditToAdd = round($amount / 110, 2);
                        $user->credit += $creditToAdd;
                        $user->save();
                    }

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "✅ تم تأكيد شحن رصيدك بمبلغ $amount ليرة.\nرصيدك الحالي: {$user->credit} كريديت.",
                    ]);
                } else {
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "⚠️ رقم العملية هذا تم تأكيده مسبقاً.",
                    ]);
                }
            } else {
                Telegram::sendMessage([
                    'chat_id' => $chatId,
                    'text' => "❌ رقم العملية غير موجود أو خاطئ، يرجى التحقق وإعادة الإرسال.",
                ]);
            }

                return response('ok');
            }

            switch ($text) {
                case '🌐 1. طلب بروكسي':
                    $proxyKeyboard = [
                        ['VIP Proxy','مودم روتيت يومي'],
                        ['رزدنتال بروكسي','Ultra SOCKS5'],
                        ['مودم روتيت 3 ساعات','مودم روتيت أسبوعي'],
                        ['↪️القائمة الرئيسية'],
                    ];

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'اختر نوع البروكسي الذي ترغب به:',
                        'reply_markup' => json_encode([
                            'keyboard' => $proxyKeyboard,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => false,
                        ]),
                    ]);
                    break;

                case 'VIP Proxy':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات VIP Proxy:\n- خدمة عالية السرعة\n- دعم 24/7\n- السعر: ...",
                    ]);
                    break;

                case 'مودم روتيت يومي':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات مودم روتيت يومي:\n- فترة استخدام يوم واحد\n- قابل للتجديد\n- السعر: ...",
                    ]);
                    break;

                case 'رزدنتال بروكسي':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات رزدنتال بروكسي:\n- عناوين IP ثابتة\n- مثالي للتصفح الآمن\n- السعر: ...",
                    ]);
                    break;

                case 'Ultra SOCKS5':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات Ultra SOCKS5:\n- سرعة عالية\n- تشفير متقدم\n- السعر: ...",
                    ]);
                    break;

                case 'مودم روتيت 3 ساعات':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات مودم روتيت 3 ساعات:\n- مدة قصيرة\n- مناسب للاستخدام المؤقت\n- السعر: ...",
                    ]);
                    break;

                case 'مودم روتيت أسبوعي':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "معلومات مودم روتيت أسبوعي:\n- استخدام لمدة أسبوع\n- سعر مخفض\n- السعر: ...",
                    ]);
                    break;

                case '↪️القائمة الرئيسية':
                    $mainKeyboard = [
                        ['🌐 1. طلب بروكسي'],
                        ['👤 2. حسابي', '🔍 3. فحص بروكسي'],
                        ['❓ 4. مساعدة'],
                    ];

                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'تم الرجوع إلى القائمة الرئيسية.',
                        'reply_markup' => json_encode([
                            'keyboard' => $mainKeyboard,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => false,
                        ]),
                    ]);
                    break;

                case '👤 2. حسابي':

                    $myAmount = [
                        ['💰 شحن حسابي'],
                        ['↪️القائمة الرئيسية'],
                    ];

                    $myCredit = 'رصيدي:  '.$user->credit.' كريديت';
                    $myID = 'رقم المعرف:  '.$user->telegram_id;


                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => $myCredit .'\n'. $myID,
                        'reply_markup' => json_encode([
                            'keyboard' => $myAmount,
                            'resize_keyboard' => true,
                            'one_time_keyboard' => false,
                        ]),
                    ]);
                    break;

                case '❓ 3. مساعدة':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "للمساعدة تواصل مع الدعم عبر الرابط التالي:\nhttps://t.me/SupportProxoBot",
                    ]);
                    break;

                case '💰 شحن حسابي':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "
                            طريقة الدفع: Syriatel Cash ⚡
                            السعر: كل 11000S.P تساوي 100 كريديت.

                            🔷 قم بارسال المبلغ المراد ايداعه إلى رقم الحساب المرفق ⬇️ ( تحويل يدوي )
                            xxxxxx

                            🔷ارسل رقم عملية التحويل ثم المبلغ بالتنسيق التالي ⬇️
                            600011111111/5000",
                    ]);
                    break;

                case '🔍 4. فحص بروكسي':
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => "أرسل لي عنوان البروكسي لأقوم بفحصه والتأكد من صلاحيته.",
                    ]);
                    break;

                default:
                    Telegram::sendMessage([
                        'chat_id' => $chatId,
                        'text' => 'عذرًا، لم أفهم طلبك. يرجى اختيار خيار من القائمة.',
                    ]);
                    break;
                }
            }


        return response('ok');
    }
}
