from ..common.Constant import Constant


# /**
# * 登場人物検索処理の値を保持する
# */
class SearchActorRequest:
    errorMsg = []

    # /**
    # * 登場人物検索処理の値を格納します
    # */
    def __init__(self, actorId, actorName, actorInfo, actorImg, opusId, timeId, groupId, userId, offset, limit, version):
        self.actorId = actorId
        self.actorName = actorName
        self.actorInfo = actorInfo
        self.actorImg = actorImg
        self.opusId = opusId
        self.timeId = timeId
        self.groupId = groupId
        self.userId = userId
        self.offset = offset
        self.limit = limit
        self.version = version

    def getActorId(self):
        return self.actorId

    def getActorName(self):
        return self.actorName

    def getActorInfo(self):
        return self.actorInfo

    def getActorImg(self):
        return self.actorImg

    def getOpusId(self):
        return self.opusId

    def getTimeId(self):
        return self.timeId

    def getGroupId(self):
        return self.groupId

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
            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：ユーザIDは' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
