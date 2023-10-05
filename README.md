# attendance-management-system

# 勤怠管理システム

## 目的
このアプリケーションは、従業員の勤怠情報を明確にし、人事評価が効率的に行えることを目的としています。利用者数100人達成が目的です。主な機能として、次の項目が含まれています。

## アプリケーションURL
[アプリケーションのURLをここに挿入]

## 他のリポジトリ
- [本プロジェクトのリポジトリ](リンク)

## 機能一覧
- 新規ユーザー登録
- ログイン機能
- メール認証機能
- 日付別勤怠ページ
- 従業員ごとの統計情報表示

## 使用技術（実行環境）
- フレームワーク：Laravel [8.83.8]
- PHP：[PHPバージョン: 7.4.9]
- データベース：MySQL [8.0.26 - MySQL Community Server - GPL]
- サーバーのOSとバージョン：[Debian GNU/Linux/10 (buster)]
- その他の技術：[使用したその他の重要な技術やライブラリ]

## テーブル設計
以下は、主要なデータベーステーブルとそのフィールドの概要です。

**usersテーブル**
- id (主キー)
- name
- email
- password
- created_at
- updated_at

**employeesテーブル**
- id (主キー)
- user_id (外部キー、usersテーブルと関連)
- first_name
- last_name
- email
- phone
- created_at
- updated_at

**attendancesテーブル**
- id (主キー)
- employee_id (外部キー、employeesテーブルと関連)
- date
- clock_in_time
- clock_out_time
- status
- created_at
- updated_at

（必要に応じて他のテーブルを追加）

## ER図
[ER図のイメージをここに挿入]

## 環境構築
プロジェクトをローカルで実行するための手順を以下に示します。

1. リポジトリをクローンする
