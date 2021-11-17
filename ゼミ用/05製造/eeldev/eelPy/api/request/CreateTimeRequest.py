# /**
# * 時系列登録処理の値を保持する
# */
class CreateTimeRequest:
    errorMsg = []

    # /**
    # * 時系列登録処理の値を保持する
    # */
    def __init__(self, timeName, opusId, userId):
        self.timeName = timeName
        self.opusId = opusId
        self.userId = userId

    def getTimeName(self):
        return self.timeName

    def getOpusId(self):
        return self.opusId

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

            # 時系列名の文字数チェック
            if (100 < len(self.timeName)):
                self.errorMsg.append('エラー ：作品名は100文字以内で入力してください')
                validationFlg = True

            # 作品IDの文字数チェック
            if (2000 < len(self.opusId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
