<?php

/**
 * 結果コードクラス
 */
class ResultCode {
    const CODE000 = '000'; // 正常
    const CODE101 = '101'; // リクエストパラメータ不正
    const CODE102 = '102'; // ユーザIDまたはパスワードが不正
    const CODE103 = '103'; // 認証情報不正（ユーザ権限がない）
    const CODE104 = '104'; // メソッド不正
    const CODE105 = '105'; // 取得、更新対象のデータが存在しない
    const CODE106 = '106'; // 既に同一キーが存在するデータを作成しようとした
    const CODE107 = '107'; // 排他制御が行われた
    const CODE108 = '108'; // 外部との通信に失敗した
    const CODE109 = '109'; // 不正なDB処理を検知した
}
