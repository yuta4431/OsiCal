========================================
技術スタック
OsisCal - 推し活スケジュール管理アプリ
========================================

1. 使用言語
----------------------------
PHP
JavaScript
HTML
CSS


2. フレームワーク・ライブラリ
----------------------------
テンプレートエンジン：Twig
カレンダー表示：FullCalendar
スタイル：プレーンな CSS（必要に応じて軽量なリセットのみ）
Ajax 通信：必要に応じて JavaScript の Fetch API を使用する


3. データベース
----------------------------
MySQL


4. アーキテクチャ
----------------------------
構成：シンプルな MVC 構造を採用する

Controller：リクエスト受付、入力値チェック、Model との橋渡し
Model：DB アクセス、ビジネスロジック
View：Twig テンプレートで HTML を生成

役割を明確に分けて保守しやすくすることを目的とする


5. 開発環境・ツール
----------------------------
エディタ：Visual Studio Code
バージョン管理：Git
リモートリポジトリ：GitHub
ローカルサーバ：PHP のビルトインサーバ（php -S）
DB 管理ツール：MySQL Workbench または phpMyAdmin（どちらか使いやすい方）


6. バージョン管理方針
----------------------------
main ブランチをベースとし、機能ごとにブランチを作成して開発する

例：
feature/requirements
feature/tech-stack
feature/db-design
feature/screen-flow
feature/er-diagram
feature/ui-design
feature/calendar
feature/event-crud

開発は必ず feature ブランチで行い、完了したら main にマージする


7. 実行・動作環境
----------------------------
実行環境：ローカル PC 上で動作させることを前提とする
OS：macOS（開発者環境に合わせる）
PHP：8 系を想定
MySQL：8 系を想定
ブラウザ：Google Chrome での動作確認を基本とする


8. 依存関係管理
----------------------------
Composer を利用して Twig 等のライブラリを管理する

利用予定の主なパッケージ：
twig/twig

その他必要になったライブラリはその都度 Composer で追加する


以上
