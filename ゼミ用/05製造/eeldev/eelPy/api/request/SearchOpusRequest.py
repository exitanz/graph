# /**
# * 作品検索処理の値を保持する
# */
class SearchOpusRequest:
    errorMsg = []

    # /**
    # * 作品検索処理の値を格納します
    # */
    def __init__(self, opusId, opusName, userId, offset, limit):
        self.opusId = opusId
        self.opusName = opusName
        self.userId = userId
        self.offset = offset
        self.limit = limit

    def getOpusId(self):
        return self.opusId

    def getOpusName(self):
        return self.opusName

    def getUserId(self):
        return self.userId

    def getOffset(self):
        return self.offset

    def getLimit(self):
        return self.limit

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
