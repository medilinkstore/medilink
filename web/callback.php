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
//会員登録
} else if ($text == '会員登録') {
  $response_format_text = [
    "type" => "template",
    "altText" => "mediLink",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/mail.png",
            "title" => "会員登録したのに確認メールが届かない",
            "text" => "こちらですか？",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "対処方法を見る",
                  "text" => "確認メールが届かない対処方法"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく対処方法を見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/qa.php#regist"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/jushin.png",
            "title" => "携帯メールの受信設定の方法がわからない",
            "text" => "それともこちら？（２つ目）",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "対処方法を見る",
                  "text" => "受信設定の方法を見る"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/qa.php#regist"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/password.jpg",
            "title" => "パスワードを忘れた／パスワードを変更したい",
            "text" => "はたまたこちら？（３つ目）",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "対処方法を見る",
                  "text" => "パスワードの対処方法を見る"
              ],
              [
                  "type" => "uri",
                  "label" => "問い合わせる（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/contact/"
              ],
              [
                  "type" => "uri",
                  "label" => "詳しく見る（ブラウザ起動）",
                  "uri" => "https://www.medilink-study.com/user_data/qa.php#regist"
              ]
            ]
          ]
      ]
    ]
  ];

//対処方法受信設定の方法を見る版
} else if ($text == '確認メールが届かない対処方法') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "確認メールは、ご登録いただいたアドレスに自動的に送信されます。下記をご確認ください。
１）「迷惑メール」フォルダをご確認ください。 
２）再度、メールアドレスに誤りがないよう、よくご確認のうえ会員登録をお手続きください。同じアドレスでは登録できないため、最初のご登録メールアドレスに誤りがなかった場合、「※すでに会員登録で使用されているメールアドレスです。」と表示され、登録ができません。 
３）上記１、２でも原因が判明しない場合、「@medilink-study.com」からのメールを受信できるよう設定を再度ご確認のうえ、お問い合わせページ(https://www.medilink-study.com/contact/)よりご連絡ください。 "
			];

//対処方法受信メール版
} else if ($text == '受信設定の方法を見る') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "キャリア（Docomo・AU・Softbank）毎に設定が異なります。詳細はコチラ(https://www.medilink-study.com/user_data/qa.php#regist)をご参照ください。"
			];

//対処方法パスワード版
} else if ($text == 'パスワードの対処方法を見る') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "（パスワードを忘れた場合） 
パスワードの再発行ページ(https://www.medilink-study.com/forgot/)より、登録メールアドレスと氏名を入力し、お手続きください。自動でメールアドレス宛に、仮パスワードが発行されます。
（パスワードを変更する） 
サイトにログインした状態で、プロフィール編集画面(https://www.medilink-study.com/mypage/change.php)より任意のパスワードに変更ができます。"
			];
//リーダーアプリ
} else if ($text == 'リーダーアプリ') {
  $response_format_text = [
    "type" => "template",
    "altText" => "mediLink",
    "template" => [
      "type" => "carousel",
      "columns" => [
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-1.jpg",
            "title" => "リーダーアプリ・コンテンツ",
            "text" => "Q1～Q3",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "「mediLink」アプリの入手方法がわからない",
                  "text" => "入手方法"
              ],
              [
                  "type" => "message",
                  "label" => "mediLinkコンテンツのデータサイズを知りたい",
                  "uri" => "データサイズ"
              ],
              [
                  "type" => "message",
                  "label" => "通信環境のない（オフライン）状態でコンテンツを使用したい",
                  "uri" => "オフライン"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-2.jpg",
            "title" => "リーダーアプリ・コンテンツ",
            "text" => "Q4～Q6",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "複数の端末で使いたい",
                  "text" => "複数"
              ],
              [
                  "type" => "message",
                  "label" => "端末の機種変更などをおこなう際の手続きを知りたい",
                  "text" => "機種変更"
              ],
              [
                  "type" => "message",
                  "label" => "「一度に利用できる端末(二台まで)を超えています」と表示され、アプリにログインできない",
                  "text" => "一度に利用できる端末"
              ]
            ]
          ],
          [
            "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img2-3.jpg",
            "title" => "リーダーアプリ・コンテンツ",
            "text" => "Q7～Q9",
            "actions" => [
              [
                  "type" => "message",
                  "label" => "メモ、マーカー、ブックマークを、複数の端末で共有したい",
                  "text" => "メモ"
              ],
              [
                  "type" => "message",
                  "label" => "「mediLink版イヤーノートアプリ」と書籍『イヤーノート』のちがいを知りたい",
                  "text" => "ちがい"
              ],
              [
                  "type" => "message",
                  "label" => "「mediLink版イヤーノートアプリ」はどうすれば使えますか？",
                  "text" => "mediLink版イヤーノートアプリ"
              ]
            ]
          ]
      ]
    ]
  ];
//リーダーアプリ

//他の事
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
//会員登録



} else if ($text == '質問') {
  $response_format_text = [
    "type" => "template",
    "altText" => "こんにちは　何かご質問ですか？（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "こんにちは　何かご質問ですか？",
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