# /**
# * 時系列編集処理の値を保持する
# */
class EditTimeRequest:
    errorMsg = []

    # /**
    # * 時系列編集処理の値を格納します
    # */
    def __init__(self, timeId, timeName, userId, version):
        self.timeId = timeId
        self.timeName = timeName
        self.userId = userId
        self.version = version

    def getTimeId(self):
        return self.timeId

    def getTimeName(self):
        return self.timeName

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
            if (len(self.timeName) == 0 or len(self.timeId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 時系列IDの文字数チェック
            if (2000 < len(self.timeId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # 時系列名の文字数チェック
            if (100 < len(self.timeName)):
                self.errorMsg.append('エラー ：時系列名は100文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (2000 < len(self.userId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True      

        except Exception as e:
            validationFlg = True

        return validationFlg
