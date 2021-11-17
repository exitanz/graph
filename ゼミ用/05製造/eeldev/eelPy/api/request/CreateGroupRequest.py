# /**
# * グループ登録処理の値を保持する
# */
class CreateActorRequest:
    errorMsg = []

    # /**
    # * グループ登録処理の値を格納します
    # */
    def __init__(self, groupName, groupInfo, groupColor, opusId, timeId, userId):
        self.groupName = groupName
        self.groupInfo = groupInfo
        self.groupColor = groupColor
        self.opusId = opusId
        self.timeId = timeId
        self.userId = userId

    def getGroupName(self):
        return self.groupName

    def getGroupInfo(self):
        return self.groupInfo

    def getGroupColor(self):
        return self.groupColor

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
            if (len(self.groupName) == 0 or len(self.opusId) == 0 or len(self.timeId) == 0 or len(self.groupColor) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # グループ名の文字数チェック
            if (100 < len(self.groupName)):
                self.errorMsg.append('エラー ：グループ名は100文字以内で入力してください')
                validationFlg = True

            # グループ詳細の文字数チェック
            if (len(self.groupInfo) != 0 and 1200 < len(self.groupInfo)):
                self.errorMsg.append('エラー ：グループ詳細は1200文字以内で入力してください')
                validationFlg = True

            # グループ色の文字数チェック
            if (100 < len(self.groupColor)):
                self.errorMsg.append('エラー ：グループ色は100文字以内で入力してください')
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
