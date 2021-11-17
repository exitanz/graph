# /**
# * 関係検索処理の値を保持する
# */
class SearchRelRequest:
    errorMsg = []

    # /**
    # * 関係検索処理の値を格納します
    # */
    def __init__(self, relId, relMstId, relMstInfo, actorId, targetId, opusId, timeId, userId, offset, limit):
        self.relId = relId
        self.relMstId = relMstId
        self.relMstInfo = relMstInfo
        self.actorId = actorId
        self.targetId = targetId
        self.opusId = opusId
        self.timeId = timeId
        self.userId = userId
        self.offset = offset
        self.limit = limit

    def getRelId(self):
        return self.relId

    def getRelMstId(self):
        return self.relMstId

    def getRelMstInfo(self):
        return self.relMstInfo

    def getActorId(self):
        return self.actorId

    def getTargetId(self):
        return self.targetId

    def getOpusId(self):
        return self.opusId

    def getTimeId(self):
        return self.timeId

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
