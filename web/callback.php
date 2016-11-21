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
            "label" => "最も多い質問",
            "text" => "最も多い質問"
          ],
          [
            "type" => "message",
            "label" => "購入方法",
            "text" => "購入方法"
          ]
      ]
    ]
  ];
} else if ($text == 'いいえ') {
  exit;
} 
//会員登録
 else if ($text == '会員登録') {
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
//最も多い質問
} else if ($text == '最も多い質問') {
  $response_format_text = [
    "type" => "template",
    "altText" => "「一度に利用できる端末(二台まで)を超えています」と表示され、アプリにログインできない（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "「一度に利用できる端末(二台まで)を超えています」と表示され、アプリにログインできない",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "利用端末"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "シリアル"
            ]
        ]
    ]
  ];
} else if ($text == 'シリアル') {
  $response_format_text = [
    "type" => "template",
    "altText" => "「シリアルナンバーを登録しても、QBオンラインが使えない、解説が表示されない（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "シリアルナンバーを登録しても、QBオンラインが使えない、解説が表示されない",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "シリアルナンバー"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "いいえ"
            ]
        ]
    ]
  ];
} else if ($text == '利用端末') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "mediLinkアプリは、アカウントごとにログイン中の端末が管理されており、２台まで同時にログインが可能です。アプリ上でログアウトすれば、端末の登録情報は解除され、別の端末でもログインができます。
なお、端末の紛失や故障、ログアウトせずに機種変更した場合など、会員さまご自身によるログアウトが不可能な場合、弊社にて端末登録解除の手続きを代行します。 
詳細は以下にアクセスしてください。
https://www.medilink-study.com/user_data/qa.php#faq1"
			];
} else if ($text == 'シリアルナンバー') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "シリアルナンバーの変更・追加を行われた際には、QBオンラインからログアウトし、再ログインを行ってください。再ログイン後も解説が表示されない場合、以下にアクセスし、詳細をご確認ください。
https://www.medilink-study.com/user_data/qa.php#faq2"
			];
} else if ($text == '購入方法') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "購入はmediLkinkストアから購入
					https://www.medilink-study.com/"
			];
} else if ($text == '質問' or $text == '使い方') {
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
//医学生
} else if ($text == '医学生に関しての質問ではない') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "ほかの質問をお願いします。"
			];
//医学生の質問
} else if ($text == '医学生に関して質問') {
  $response_format_text = [
    "type" => "template",
    "altText" => "医学生に関して質問",
    "template" => [
      "type" => "buttons",
      "thumbnailImageUrl" => "https://" . $_SERVER['SERVER_NAME'] . "/img1.jpg",
      "title" => "医学生に関して質問",
      "text" => "こちらですか?",
      "actions" => [
          [
            "type" => "message",
            "label" => "医学生会員とは",
            "text" => "医学生会員とは"
          ],
          [
            "type" => "message",
            "label" => "医学生会員特典",
            "text" => "医学生会員特典"
          ],
          [
            "type" => "message",
            "label" => "登録条件",
            "text" => "登録条件"
          ]
      ]
    ]
  ];
//医学生会員とは
} else if ($text == '医学生会員とは') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "「医学生会員」とは、医師をめざす学生様を対象としたmediLink会員の種別です。
学年に応じたサービスを提供するため、学生証の画像をご登録いただくことで、ご所属と学年を確認いたします。今後、医学生会員限定の特典も続々ご用意する予定です。"
			];
//医学生会員特典
}  else if ($text == '医学生会員特典') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "「『病気がみえる』書籍＋アプリセットがオトクに買える！
医学生会員の方は、mediLinkストアで『病気がみえる』の書籍とアプリをセットでオトクに購入することができます。"
			];
//登録条件
}  else if ($text == '登録条件') {
	  $response_format_text = [
		    	"type" => "text",
			"text" => "「医学生会員」には、下記のすべての条件を満たす方にお申し込みいただけます。

1・mediLink会員である
2・申込み時点で国内の大学医学部（医学科）に在籍している、または申込み時点以降の医師国家試験の受験が確定している"
			];
} else if ($text == '医学生' or $text == '医学生会員' or $text == '医学生会員って') {
  $response_format_text = [
    "type" => "template",
    "altText" => "医学生に関するご質問ですか？（はい／いいえ）",
    "template" => [
        "type" => "confirm",
        "text" => "医学生に関するご質問ですか？",
        "actions" => [
            [
              "type" => "message",
              "label" => "はい",
              "text" => "医学生に関して質問"
            ],
            [
              "type" => "message",
              "label" => "いいえ",
              "text" => "医学生に関しての質問ではない"
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