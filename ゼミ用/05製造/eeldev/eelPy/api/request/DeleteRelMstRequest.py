# /**
# * 関係性削除処理の値を保持する
# */
class DeleteOpusRequest:
    errorMsg = []

    # /**
    # * 関係性削除処理の値を格納します
    # */
    def __init__(self, relMstId, userId):
        self.relMstId = relMstId
        self.userId = userId

    def getRelMstId(self):
        return self.relMstId

    def getUserId(self):
        return self.userId

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.relMstId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係性IDの文字数チェック
            if (2000 < len(self.relMstId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
