# /**
# * グラフ検索処理の値を保持する
# */
class SearchGraphRequest:
    errorMsg = []

    # /**
    # * グラフ検索処理の値を格納します
    # */
    def __init__(self, timeId, opusId, actorName, groupName, relMstName):
        self.timeId = timeId
        self.opusId = opusId
        self.actorName = actorName
        self.groupName = groupName
        self.relMstName = relMstName

    def getTimeId(self):
        return self.timeId

    def getOpusId(self):
        return self.opusId

    def getActorName(self):
        return self.actorName

    def getGroupName(self):
        return self.groupName

    def getRelMstName(self):
        return self.relMstName

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.opusId) == 0 or len(self.timeId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 作品IDの文字数チェック
            if (2000 < len(self.opusId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # 時系列IDの文字数チェック
            if (2000 < len(self.timeId)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True   

            # 登場人物名の文字数チェック
            if (len(self.actorName) != 0 and 100 < len(self.actorName)):
                self.errorMsg.append('エラー ：登場人物名は100文字以内で入力してください')
                validationFlg = True

            # グループ名の文字数チェック
            if (len(self.groupName) != 0 and 100 < len(self.groupName)):
                self.errorMsg.append('エラー ：グループ名は100文字以内で入力してください')
                validationFlg = True    

            # 関係性名の文字数チェック
            if (len(self.relMstName) != 0 and 100 < len(self.relMstName)):
                self.errorMsg.append('エラー ：関係性名は100文字以内で入力してください')
                validationFlg = True             

        except Exception as e:
            validationFlg = True

        return validationFlg
