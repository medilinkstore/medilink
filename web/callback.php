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
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "よくある質問",
      "text" => "こちらですか?",
      "actions" => [
          [
            "type" => "message",
            "label" => "会員登録・ログイン方法",
            "data" => "会員登録"
          ],
          [
            "type" => "message",
            "label" => "リーダーアプリ・コンテンツ",
            "text" => "リーダーアプリ"
          ],
          [
            "type" => "message",
            "label" => "購入方法",
            "text" => "購入方法"
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
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
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
                  "uri" => "https://www.medilink-study.com/contact/" . $_SERVER['SERVER_NAME'] . "/"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/about.php" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "▲▲レストラン",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=222"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=222"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "■■レストラン",
            "text" => "はたまたこちら？（３つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "予約する",
                  "data" => "action=rsv&itemid=333"
              ],
              [
                  "type" => "postback",
                  "label" => "電話する",
                  "data" => "action=pcall&itemid=333"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://" . $_SERVER['SERVER_NAME'] . "/"
              ]
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