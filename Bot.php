<?php
//Config
define('token', ""); //Token
define('bot_url', "https://api.telegram.org/bot" . token);
define('bot_dl_url', "https://api.telegram.org/file/bot" . token);
define('url', "https://dangerboygraphic.ir/");
$admins = [
    795455488,  //ID User
];

$update_array = json_decode(file_get_contents("php://input"), true);
//Variables
if (isset($update_array["message"])) {
    $text               = $update_array["message"]["text"];
    $chat_id            = $update_array["message"]["chat"]["id"];
    $from_id            = $update_array["message"]["from"]["id"];
    $first_name         = $update_array["message"]["chat"]["first_name"];
    $last_name          = $update_array["message"]["chat"]["last_name"];
    $username           = $update_array["message"]["chat"]["username"];
    $message_id         = $update_array["message"]["message_id"];
    $chat_type          = $update_array["message"]["chat"]["type"];
} elseif (isset($update_array["message"])) {
    $text_replied       = $update_array["message"]["text"];
    $reply_msg_id       = $update_array["message"]["message_id"];
} elseif (isset($update_array["callback_query"])) {
    $text               = $update_array["callback_query"]["message"]["text"];
    $first_name         = $update_array["callback_query"]["message"]["chat"]["first_name"];
    $last_name          = $update_array["callback_query"]["message"]["chat"]["last_name"];
    $username           = $update_array["callback_query"]["message"]["chat"]["username"];
    $callbackdata       = $update_array["callback_query"]["data"];
    $message_id         = $update_array["callback_query"]["message"]["message_id"];
    $callback_query_id  = $update_array["callback_query"]["id"];
    $chat_id            = $update_array["callback_query"]["message"]["chat"]["id"];
    $from_id            = $update_array["callback_query"]["message"]["from"]["id"];
}
//Functions
function send_reply($method, $post_param)
{
    $ch = curl_init(bot_url . '/' . $method);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $post_param,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYHOST => false,
        CURLOPT_SSL_VERIFYPEER => false,
    ]);
    $response = curl_exec($ch);
    var_dump(curl_error($ch), $response);
    curl_close($ch);
    return $response;
}
//KeyBoards
$contact_kb = [
    'keyboard' => [
        [
            [
                'text' => 'ارسال شماره تلفن',
                'request_contact' => true
            ]
        ],

        [
            ['text' => 'ارتباط با ادمین']
        ],
    ],
    'resize_keyboard' => true,
    'one_time_keyboard' => true
];
$location_kb = [
    'keyboard' => [
        [
            [
                'text' => 'ارسال لوکیشن',
                'request_location' => true
            ]
        ],
        [
            ['text' => 'ارتباط با ادمین'],
        ],
    ],
    'resize_keyboard' => true,
    'one_time_keyboard' => true
];
$contact_kb  = json_encode($contact_kb);
$location_kb  = json_encode($location_kb);
if ($chat_type == "private") {

    if (in_array($from_id, $admins)) {
        //کدهای مربوط به ادیمن
    } else {
        //کدهای مربوط به کاربر
        if ($text == '/start') {
            $reply = '❗️کاربر گرامی برای مطلع شدن از شرایط عضویت میبایست در مرحله اول ثبت نام در ربات Iɴғɪɴɪᴛʏ Pᴀᴄᴋᴀɢᴇ انجام داده تا نهایتا شرایط و قوانین عضویت برای شما ارسال شود به همین منظور میبایست شماره اکانت و موقعیت مکانی خود را برای ربات ارسال نمایید .

⚠️ دقت داشته باشید اگر از شماره مجازی استفاده میکنید ربات شما را بصورت خودکار حذف خواهد کرد میبایست شماره اکانت ایران تهیه نمایید .';
            file_put_contents('response.txt', send_reply(
                'sendMessage',
                [
                    'chat_id' => $chat_id,
                    'text' => $reply,
                    'reply_markup' => $contact_kb
                ]
            ));
        } elseif (isset($update_array["message"]["contact"])) {
            $reply = "⚠️ دقت داشته باشید اگر موقعیت مکانی شما تقلبی و غیرصحیح باشد ربات شما را بصورت خودکار حذف خواهد کرد و یا اگر با نسخه ویندوزی و یا لینوکسی تلگرام وارد شدید حتما ارتباط خود را تعویض و با پلتفرم های android و ios این کار را انجام دهید تا بتوانید موقعیت خود را ارسال نمایید (هنگام ارسال Location تلفن همراه بایستی روشن باشد) .";
            file_put_contents('response.txt', send_reply(
                'sendMessage',
                [
                    'chat_id' => $chat_id,
                    'text' => $reply,
                    'reply_markup' => $location_kb
                ]
            ));
        } elseif (isset($update_array["message"]["location"])) {
            $reply = "با سلام ، کانال های خصوصی Iɴғɪɴɪᴛʏ Pᴀᴄᴋᴀɢᴇ تمام مواردهای آموزشی نقشه را که در کانال اصلی قرار داده شده است را دارا بوده و به صورت هفتگی اطلاعات این کانال ها بروزرسانی میشود که به شرح زیر است :

📌 کانال اول : در خصوص انواع کتاب ، مقالات و Research چه به زبان فارسی و چه به زبان انگلیسی فعالیت دارد و همچنین در خصوص ابزارهای نایاب مورد نیاز علوم سایبری نیز محتوا خواهد گرفت .

📌 کانال دوم : مخصوص پکیج های آموزشی از سایت های معروف و در هر زمینه ای از علوم کامپیوتر محتوا خواهد گرفت و لازم به ذکر است پکیج هایی که در سطح اینترنت پخش شده را نیز دارا میباشد .

💳 شرایط عضویت : پرداخت هزینه دویست هزار تومان برای عضویت مادام در کانال های خصوصی دریافت میشود بعد از پرداخت مبلغ عضویت ، یک عکس از کارت پرداختی خود به گونه ای که فقط شماره کارت و اسم فامیل شما دیده شود برای ربات ارسال کنید و منتظر دریافت لینک ها باشید (علت درخواست عکس از کارت این است که افراد سودجو با استفاده از اطلاعات حساب های دزدی در درگاه ما پرداخت انجام ندهند) . 

📣 کسانی که مراحل عضویت را انجام داده و بعد از آن مایل به انصراف از عضویت کانال ها باشند ، میتوانند کانال ها را ترک نمایند و این نکته در اینجا الزامیست که مبلغ پرداختی به هیچ وجه عودت داده نخواهد شد .

📣 ادمین های ربات هر چهار ساعت ربات را چک میکنند لطفا صبور باشید .

📣 اگر مطالب کانال به هر نحوی نشر داده شود آن شخص شناسایی شده و از کانال ها برای همیشه حذف خواهد شد لازم به ذکر است ارسال محتوا کانال در Save Message موردی نخواهد داشت .

📣 افراد اگر درخواست پکیج یا کتاب خاصی دارند میتوانند به آیدی ربات @InfinityPackagebot مراجعه و درخواست خود را مطرح نمایند و در صورت امکان انجام خواهد شد .


🌐 درگاه پرداخت Zarinpal :";
            send_reply(
                'sendMessage',
                [
                    'chat_id' => $chat_id,
                    'text' => $reply,
                ]
            );
        }
    }
}
