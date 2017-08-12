# テーブルスタイル置換ツール

docxファイル内のテーブルのスタイルを、ファイル内の特定のテーブルスタイルに一括で置換するツールです。

## 必要要件

PHP 5.6 以上

Windowsではまだ動作を確認出来ていません。

## インストール

```
$ composer global require kojiro526/php-docxtable
```

## 使い方※

docxファイル内のテーブルスタイルには内部的にIDが割り当てられており、本文内のテーブルのスタイルIDを上書きすれば、テーブルのスタイルを変更できます。

### スタイルIDの確認

まず、以下のコマンドでdocxファイル内のテーブルスタイルのIDを取得します。

```
$ docxtable-php styles -f ./example.docx
1:
 styleId: a2
 name: Normal Table
2:
 styleId: af5
 name: Table Grid
3:
 styleId: MyTable
 name: MyTable
 ```

上記の「MyTable」という名前のスタイルに変更したい場合、そのstyleId（"MyTable"）を控えます。

### スタイルIDの変更

次に、以下のコマンドでdocxファイル内の全てのテーブルのスタイルを"MyTable"というIDで上書きします。

```
$ docxtable-php update -f ./example.docx -s MyTable -o ./output.docx
```

以上で、テーブルのスタイル変更は完了です。

