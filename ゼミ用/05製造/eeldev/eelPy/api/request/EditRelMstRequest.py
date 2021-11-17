# /**
# * 関係性編集処理の値を保持する
# */
class EditRelMstRequest:
    errorMsg = []

    # /**
    # * 関係性編集処理の値を格納します
    # */
    def __init__(self, relMstId, relMstName, userId, version):
        self.relMstId = relMstId
        self.relMstName = relMstName
        self.userId = userId
        self.version = version

    def getRelMstId(self):
        return self.relMstId

    def getRelMstName(self):
        return self.relMstName

    def getUserId(self):
        return self.userId

    def getVersion(self):
        return self.version

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.relMstName) == 0 or len(self.relMstId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係性IDの文字数チェック
            if (2000 < len(self.relMstId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # 関係性名の文字数チェック
            if (100 < len(self.relMstName)):
                self.errorMsg.append('エラー ：関係性名は100文字以内で入力してください')
                validationFlg = True      

        except Exception as e:
            validationFlg = True

        return validationFlg
