from ..common.Constant import Constant


# /**
# * 作品登録処理の値を保持する
# */
class CreateActorRequest:
    errorMsg = []

    # /**
    # * 作品登録処理の値を格納します
    # */
    def __init__(self, actorName, actorInfo, actorImg, opusId, timeId, groupId, userId):
        self.actorName = actorName
        self.actorInfo = actorInfo
        self.actorImg = actorImg
        self.opusId = opusId
        self.timeId = timeId
        self.groupId = groupId
        self.userId = userId

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

    def getErrorMsg(self):
        return self.errorMsg

    # /**
    # * バリデーションチェックをします
    # */
    def validation(self):
        validationFlg = False

        try:
            # 入力項目チェック
            if (len(self.actorName) == 0 or len(self.opusId) == 0 or len(self.timeId) == 0 or len(
                    self.groupId) == 0 or len(self.userId) == 0):
                self.errorMsg.append('エラー ：必須項目が入力されていません')
                validationFlg = True

            # 登場人物名の文字数チェック
            if (100 < len(self.actorName)):
                self.errorMsg.append('エラー ：登場人物名は100文字以内で入力してください')
                validationFlg = True

            # 登場人物説明の文字数チェック
            if (1200 < len(self.actorInfo)):
                self.errorMsg.append('エラー ：登場人物説明は1200文字以内で入力してください')
                validationFlg = True

            # 作品IDの文字数チェック
            if (Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.opusId)):
                self.errorMsg.append(
                    'エラー ：登場人物説明は' + Constant.OPUS_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # 時系列IDの文字数チェック
            if (Constant.TIME_ID_DIGIT + len(Constant.TIME_ID_STR) < len(self.timeId)):
                self.errorMsg.append(
                    'エラー ：時系列IDは' + Constant.TIME_ID_DIGIT + len(Constant.TIME_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # グループIDの文字数チェック
            if (Constant.GROUP_ID_DIGIT + len(Constant.OPUS_ID_STR) < len(self.groupId)):
                self.errorMsg.append(
                    'エラー ：グループIDは' + Constant.GROUP_ID_DIGIT + len(Constant.OPUS_ID_STR) + '文字以内で入力してください')
                validationFlg = True

            # ユーザIDの文字数チェック
            if (Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) < len(self.userId)):
                self.errorMsg.append(
                    'エラー ：登場人物説明は' + Constant.USER_ID_DIGIT + len(Constant.USER_ID_STR) + '文字以内で入力してください')
                validationFlg = True

        except Exception as e:
            validationFlg = True

        return validationFlg
