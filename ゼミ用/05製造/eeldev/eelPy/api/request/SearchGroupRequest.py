# /**
# * グループ検索処理の値を保持する
# */
class SearchGroupRequest:
    errorMsg = []

    # /**
    # * グループ検索処理の値を格納します
    # */
    def __init__(self, groupId, groupName, groupInfo, opusId, timeId, userId, offset, limit):
        self.groupId = groupId
        self.groupName = groupName
        self.groupInfo = groupInfo
        self.opusId = opusId
        self.timeId = timeId
        self.userId = userId
        self.offset = offset
        self.limit = limit

    def getGroupId(self):
        return self.groupId

    def getGroupName(self):
        return self.groupName

    def getGroupInfo(self):
        return self.groupInfo

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
