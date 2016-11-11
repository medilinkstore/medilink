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
            "text" => "会員登録"
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
} else if ($text == '会員登録') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こちらの事項ですか?",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "会員登録・ログイン方法",
      "text" => "こちらですか?",
      "actions" => [
          [
            "type" => "message",
            "label" => "会員登録したのに確認メールが届かない",
            "text" => "確認メール"
          ],
          [
            "type" => "message",
            "label" => "携帯メールの受信設定の方法がわからない",
            "text" => "携帯メール"
          ],
          [
            "type" => "message",
            "label" => "パスワードを忘れた／パスワードを変更したい",
            "text" => "パスワード"
          ],
          [
            "type" => "message",
            "label" => "違うやつ",
            "text" => "そのほか"
          ]
      ]
    ]
  ];
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
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "mediLinkの構成",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "見る",
                  "data" => "action=rsv&itemid=222"
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
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "mediLinkアプリ 複数端末でのご利用について",
            "text" => "はたまたこちら？（３つ目）",
            "actions" => [
              [
                  "type" => "postback",
                  "label" => "見る",
                  "data" => "action=rsv&itemid=222"
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