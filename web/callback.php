<?php
$accessToken = getenv('LINE_CHANNEL_ACCESS_TOKEN');


//ユーザーからのメッセージ取得
$json_string = file_get_contents('php://input');
$jsonObj = json_decode($json_string);

$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//メッセージ取得
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//ReplyToken取得
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};

//メッセージ以外のときは何も返さず終了
if($type != "text"){
	exit;
}

//返信データ作成
if ($text == 'はい') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こちらの事項ですか?",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.png",
      "title" => "よくある質問",
      "text" => "こちらですか?",
      "actions" => [
          [
            "type" => "postback",
            "label" => "会員登録・ログイン方法",
            "data" => "action=buy&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "リーダーアプリ・コンテンツ",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "QBオンライン",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "postback",
            "label" => "医ンプット",
            "data" => "action=pcall&itemid=123"
          ],
          [
            "type" => "uri",
            "label" => "詳しく見る",
            "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
          ],
          [
            "type" => "message",
            "label" => "違うやつ",
            "text" => "他の事"
          ]
      ]
    ]
  ];
} else if ($text == 'いいえ') {
  exit;
} else if ($text == '他の事') {
  $response_format_text = [
    "type" => "template",
    "altText" => "mediLink",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.png",
            "title" => "mediLinkとは",
            "text" => "こちらですか？",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "見る",
                  "data" => "action=rsv&itemid=111"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/about.php"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.png",
            "title" => "mediLinkの構成",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/about.php"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.png",
            "title" => "mediLinkアプリ 複数端末でのご利用について",
            "text" => "もしくはこれ？（３つ目）",
            "actions" => [
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/about.php"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
            ]
          ]
      ]
    ]
  ];
} else {
  $response_format_text = [
    "type" => "template",
    "altText" => "こんにちわ 何かご用ですか？（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "こんにちわ 何かご用ですか？",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "はい"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "いいえ"
            ]
        ]
    ]
  ];
}

$post_data = [
	"replyToken" => $replyToken,
	"messages" => [$response_format_text]
	];

$ch = curl_init("https://api.line.me/v2/bot/message/reply");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json; charser=UTF-8',
    'Authorization: Bearer ' . $accessToken
    ));
$result = curl_exec($ch);
curl_close($ch);
