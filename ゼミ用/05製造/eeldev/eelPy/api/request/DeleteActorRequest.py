# /**
# * 登場人物削除処理の値を保持する
# */
class DeleteActorRequest:
    errorMsg = []

    # /**
    # * 登場人物削除処理の値を格納します
    # */
    def __init__(self, actorId, userId):
        self.actorId = actorId
        self.userId = userId

    def getActorId(self):
        return self.actorId

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
            if (len(self.timeName) == 0 or len(self.opusId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 登場人物IDの文字数チェック
            if (2000 < len(self.actorId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
