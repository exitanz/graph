# /**
# * 関係性検索処理の値を保持する
# */
class SearchRelMstRequest:
    errorMsg = []

    # /**
    # * 関係性検索処理の値を格納します
    # */
    def __init__(self, relMstId, relMstName, opusId, userId, offset, limit):
        self.relMstId = relMstId
        self.relMstName = relMstName
        self.opusId = opusId
        self.userId = userId
        self.offset = offset
        self.limit = limit

    def getRelMstId(self):
        return self.relMstId

    def getRelMstName(self):
        return self.relMstName

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
