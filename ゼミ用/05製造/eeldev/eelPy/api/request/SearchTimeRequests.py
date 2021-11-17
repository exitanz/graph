# /**
# * 時系列検索処理の値を保持する
# */
class SearchTimeRequest:
    errorMsg = []

    # /**
    # * 時系列検索処理の値を格納します
    # */
    def __init__(self, timeId, timeName, opusId, userId, offset, limit):
        self.timeId = timeId
        self.timeName = timeName
        self.opusId = opusId
        self.userId = userId
        self.offset = offset
        self.limit = limit

    def getTimeId(self):
        return self.timeId

    def getTimeName(self):
        return self.timeName

    def getOpusId(self):
        return self.opusId

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
