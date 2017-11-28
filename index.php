<?php
/*
این ربات نوشته شده توسط دانیال ملک زاده (@JanPHP)و دریافت اخبار : @Danial_Rbo
*/
//====@mriven====//
define('API_KEY','446095521:AAHjlWQmUkW-9mFmszR4RisqX56kXbfr-_4');
//====@mriven====//
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//====@mriven====//
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$photo = $update->message->photo;
$video = $update->message->video;
$sticker = $update->message->sticker;
$file = $update->message->document;
$music = $update->message->audio;
$voice = $update->message->voice;
$data = $update->callback_query->data;
$message_id = $update->callback_query->message->message_id;
$admin = 328130490;
$Sticker = file_get_contents("data/$from_id/Sticker.txt");
$step = file_get_contents("data/$from_id/step.txt");
//====@mriven====//
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>Html
]);
}
function sendphoto($ChatId, $axesh, $matnesh){
	makereq('sendPhoto',[
	'chat_id'=>$ChatId,
	'photo'=>$axesh,
	'caption'=>$matnesh
	]);
	}
function sendsticker($chatid,$stickerid,$caption){
    bot('sendsticker',[
        'chatid'=>$ChatId,
        'sticker'=>$stickerid,
        'caption'=>$caption
    ]);
}
function save($filename,$TXTdata){
	$myfile = fopen($filename, "w") or die("unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
}
//====@mriven====//
if($textmessage == "/start"){
	if(!file_exists("data/$from_id/step.txt")){
		mkdir("data/$from_id");
		save("data/$from_id/step.txt","none");
		save("data/$from_id/Sticker.txt","none");
		$members = file_get_contents("data/Member.txt");
		save("data/Member.txt",$members."$from_id\n");
	}
	var_dump(makereq('sendMessage',[
	'chat_id'=>$chat_id,
	'text'=>"سلام $name 🤚
➖➖➖➖➖➖➖
😊به ربات جستجو استیکر خوش اومدی😊
➖➖➖➖➖➖➖
😉وارد بخش راهنما شو ببین که باید چیکار کنی😉
➖➖➖➖➖➖➖
🆔: @DarkSkyTM",
       'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode(['keyboard'=>[
	[
['text'=>"🔎جستجو استیکر🔎"]
],
[
['text'=>"📚راهنما📚"],['text'=>"😋استیکر های من😋"]
],
[
['text'=>"🗣پشتیبانی🗣"]
                ]
       ],
'resize_keyboard'=>false
              ])
      ]));
}
//====@mriven====//
elseif ($textmessage == '🏡بازگشت🏡') {
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"سلام $name 🤚
➖➖➖➖➖➖➖
😊به ربات جستجو استیکر خوش اومدی😊
➖➖➖➖➖➖➖
😉وارد بخش راهنما شو ببین که باید چیکار کنی😉
➖➖➖➖➖➖➖
🆔: @DarkSkyTM",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
['text'=>"🔎جستجو استیکر🔎"]
],
[
['text'=>"📚راهنما📚"],['text'=>"😋استیکر های من😋"]
],
[
['text'=>"🗣پشتیبانی🗣"]
                ]
       ],
'resize_keyboard'=>false
              ])
      ]));
}
//====@mriven====//
elseif ($textmessage == '🔎جستجو استیکر🔎') {
save("data/$from_id/step.txt","sti");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"😊دوست من $name لطفا نام پک استیکرتو وارد کن مثل:😊
👉Pixelab👈",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                 ['text'=>"🏡بازگشت🏡"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
}
//====@mriven====//
elseif($step == "sti"){
	save("data/$from_id/Sticker.txt",$textmessage);
	save("data/$from_id/step.txt","sti");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"😊دوست من $name گشتم😊
نتیجه✌️:
➖➖➖➖➖➖
[Sticker](https://telegram.me/addstickers/$textmessage)
➖➖➖➖➖➖
😉روشو بزن ببین که هست یا نه😉
یه دونه از استیکرتم پایین برات میفرستم الان🤒👇",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                 ['text'=>"🏡بازگشت🏡"]
                ]
                
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		sleep("5");
    		bot('sendsticker', [
             'chat_id' => $chatid,
            'sticker' => "https://telegram.me/addstickers/$textmessage",
            'caption' => "✔",
]);
Sendmessage($chat_id,"بفرمایید✋");
}
//====@mriven====//
elseif($textmessage ==  "😋استیکر های من😋"){
	if($esmesh == "none"){
		sendMessage($chat_id,"❌هنوز چیزی جستجو نکردی❌");
	}else{
		sendMessage($chat_id,"😋نام شما: $name
😋ایدی شما: $username
😋اخرین سرچ شما: $Sticker
😋ایدی عددی شما: $from_id");
	}
}
//====@mriven====//
elseif ($textmessage == '📚راهنما📚'){
sendmessage($chat_id,'خب دوست من اول وارد بخش جستجو شو اسم پکتو وارد کن ربات لینک ورود به استیکرو بهت میده بعدش میتونی استیکر های که سرچ زدیو تو بخش استیکر های من ببینی.');
}
//====@mriven====//
elseif ($textmessage == '🗣پشتیبانی🗣'){
sendmessage($chat_id,'😉برای ارتباط با سازنده کلیک کنید:😉
@mriven
@mrivenbot');
}
//====@mriven====//
elseif ($textmessage == 'مدیریت')
if ($from_id == $admin)
{
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"سلام قربان😃👋\nبه پنل مدیریت📋 ربات خود خوش آمدید😁",
'reply_to_message_id'=>$message_id,
        'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'keyboard'=>[
              [
['text'=>"📤پیام همگانی📤"]
],
[
['text'=>"🏡بازگشت🏡"]
                       ]
                  ],
'resize_keyboard'=>false
                       ])
               ]));
}else{
sendmessage($chat_id,"🙃تو ادمین نیستی الکی میگی که ادمینی از این دستور استفاده نکن😂");
}
elseif ($textmessage == '📤پیام همگانی📤')
if ($from_id == $admin)
{
save("data/$from_id/step.txt","sendtoall");
var_dump(makereq('sendMessage',[
'chat_id'=>$update->message->chat->id,
'text'=>"پیام خود را ارسال کنید : ",
'parse_mode'=>'MarkDown',
'reply_markup'=>json_encode(['keyboard'=>
[[['text'=>"🏡بازگشت🏡"]]],
'resize_keyboard'=>false
                 ])
            ]
        )
    );
}else{
SendMessage($chat_id,"شما ادمین نیستید.");
}
elseif ($step == 'sendtoall')
{
SendMessage($chat_id,"پیام در حال ارسال میباشد...⏰");
save("data/$from_id/step.txt","none");
$fp = fopen( "data/users.txt", 'r');
while( !feof( $fp)) {
$ckar = fgets( $fp);
SendMessage($ckar,$textmessage);
}
SendMessage($chat_id,"پیام شما با موفقیت به تمام کاربران ارسال شد👍");
}
?>
