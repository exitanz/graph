# /**
# * 関係登録処理の値を保持する
# */
class CreateRelRequest:
    errorMsg = []

    # /**
    # * 関係登録処理の値を格納します
    # */
    def __init__(self, relMstId, relMstInfo, actorId, targetId, opusId, timeId, userId):
        self.relMstId = relMstId
        self.relMstInfo = relMstInfo
        self.actorId = actorId
        self.opusId = opusId
        self.timeId = timeId
        self.userId = userId

    def getRelMstId(self):
        return self.relMstId

    def getRelMstInfo(self):
        return self.relMstInfo

    def getActorId(self):
        return self.actorId

    def getOpusId(self):
        return self.opusId

    def getTimeId(self):
        return self.timeId

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
            if (len(self.relMstId) == 0 or len(self.actorId) == 0 or len(self.targetId) == 0 or len(self.opusId) == 0 or len(self.timeId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 関係性IDの文字数チェック
            if (100 < len(self.relMstId)):
                self.errorMsg.append('エラー ：登場人物名は100文字以内で入力してください')
                validationFlg = True

            # 関係詳細の文字数チェック
            if (100 < len(self.relMstInfo)):
                self.errorMsg.append('エラー ：関係詳細は100文字以内で入力してください')
                validationFlg = True

            # 登場人物IDの文字数チェック
            if (len(self.actorId) != 0 and 2000 < len(self.actorImg)):
                self.errorMsg.append('エラー ：登場人物画像は2000文字以内で入力してください')
                validationFlg = True

            # 作品IDの文字数チェック
            if (2000 < len(self.opusId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # 時系列IDの文字数チェック
            if (2000 < len(self.timeId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
